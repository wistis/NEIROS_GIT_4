<?php

//	Класс изображает полезную нагрузку...
class ExampleClass
{

    public $user;

    public function test()
    {
        $socket = stream_socket_server("tcp://cloud.neiros.ru:8890", $errno, $errstr);

        if (!$socket) {
          //  echo "socket unavailable<br />";
          //  die($errstr . "(" . $errno . ")\n");
        }


        $connects = array();
        $ii = 0;
        while (1) {
           // echo "main while...<br />";
            //формируем массив прослушиваемых сокетов:
            $read = $connects;
            $read [] = $socket;
            $write = $except = null;

            if (!stream_select($read, $write, $except, null)) {//ожидаем сокеты доступные для чтения (без таймаута)
                break;
            }

            if (in_array($socket, $read)) {//есть новое соединение то обязательно делаем handshake
                //принимаем новое соединение и производим рукопожатие:
                if (($connect = stream_socket_accept($socket, -1)) && $info = $this->handshake($connect)) {
                //    echo "new connection...<br />";
                 //   echo "connect=" . $connect . ", info=" . $info['hash'] . "<br />OK<br />";
                    //echo "info<br />";
                    //var_dump($info);

                    $connects[] = $connect;//добавляем его в список необходимых для обработки
                    $this->onOpen($connect, $info);//вызываем пользовательский сценарий
                }
                unset($read[array_search($socket, $read)]);
            }

            foreach ($read as $connect) {//обрабатываем все соединения
                $data = fread($connect, 100000);

                if (!$data) { //соединение было закрыто
                 //   echo "connection closed...".$info['hash']."<br />";
                    fclose($connect);
                    unset($connects[array_search($connect, $connects)]);
                    // unset($this->user[$info['hash']]);
                     $this->onClose($connect);//вызываем пользовательский сценарий
                    continue;
                }

            //    var_dump($this->user);
                $this->onMessage($connect, $data);//вызываем пользовательский сценарий
            }

            /*if( ( round(microtime(true),2) - $starttime) > 100) {
                echo "time = ".(round(microtime(true),2) - $starttime);
                echo "exit <br />\r\n";
                fclose($socket);
                echo "connection closed OK<br />\r\n";
                exit();
            }*/


        }

        fclose($socket);
    }

    public function handshake($connect)
    { //Функция рукопожатия
        $info = array();

        $line = fgets($connect);
        $header = explode(' ', $line);
        $info['method'] = $header[0];
        $info['uri'] = $header[1];
        $info['hash'] = md5(trim($header[1], '/'));
        $this->user[md5(trim($header[1], '/'))] = $connect;

        //считываем заголовки из соединения
        while ($line = rtrim(fgets($connect))) {
            if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
                $info[$matches[1]] = $matches[2];
            } else {
                break;
            }
        }

        $address = explode(':', stream_socket_get_name($connect, true)); //получаем адрес клиента
        $info['ip'] = $address[0];
        $info['port'] = $address[1];

        if (empty($info['Sec-WebSocket-Key'])) {
            return false;
        }

        //отправляем заголовок согласно протоколу вебсокета
        $SecWebSocketAccept = base64_encode(pack('H*', sha1($info['Sec-WebSocket-Key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept:" . $SecWebSocketAccept . "\r\n\r\n";
        fwrite($connect, $upgrade);

        return $info;
    }

    public function encode($payload, $type = 'text', $masked = false)
    {
        $frameHead = array();
        $payloadLength = strlen($payload);

        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;

            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;

            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;

            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }

        // set mask and payload length (using 1, 3 or 9 bytes)
        if ($payloadLength > 65535) {
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for ($i = 0; $i < 8; $i++) {
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }
            // most significant bit MUST be 0
            if ($frameHead[2] > 127) {
                return array('type' => '', 'payload' => '', 'error' => 'frame too large (1004)');
            }
        } elseif ($payloadLength > 125) {
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach (array_keys($frameHead) as $i) {
            $frameHead[$i] = chr($frameHead[$i]);
        }
        if ($masked === true) {
            // generate a random mask:
            $mask = array();
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);

        // append payload to frame:
        for ($i = 0; $i < $payloadLength; $i++) {
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }

        return $frame;
    }

    public function decode($data)
    {
        $unmaskedPayload = '';
        $decodedData = array();

        // estimate frame type:
        $firstByteBinary = sprintf('%08b', ord($data[0]));
        $secondByteBinary = sprintf('%08b', ord($data[1]));
        $opcode = bindec(substr($firstByteBinary, 4, 4));
        $isMasked = ($secondByteBinary[0] == '1') ? true : false;
        $payloadLength = ord($data[1]) & 127;

        // unmasked frame is received:
        if (!$isMasked) {
            return array('type' => '', 'payload' => '', 'error' => 'protocol error (1002)');
        }

        switch ($opcode) {
            // text frame:
            case 1:
                $decodedData['type'] = 'text';
                break;

            case 2:
                $decodedData['type'] = 'binary';
                break;

            // connection close frame:
            case 8:
                $decodedData['type'] = 'close';
                break;

            // ping frame:
            case 9:
                $decodedData['type'] = 'ping';
                break;

            // pong frame:
            case 10:
                $decodedData['type'] = 'pong';
                break;

            default:
                return array('type' => '', 'payload' => '', 'error' => 'unknown opcode (1003)');
        }

        if ($payloadLength === 126) {
            $mask = substr($data, 4, 4);
            $payloadOffset = 8;
            $dataLength = bindec(sprintf('%08b', ord($data[2])) . sprintf('%08b', ord($data[3]))) + $payloadOffset;
        } elseif ($payloadLength === 127) {
            $mask = substr($data, 10, 4);
            $payloadOffset = 14;
            $tmp = '';
            for ($i = 0; $i < 8; $i++) {
                $tmp .= sprintf('%08b', ord($data[$i + 2]));
            }
            $dataLength = bindec($tmp) + $payloadOffset;
            unset($tmp);
        } else {
            $mask = substr($data, 2, 4);
            $payloadOffset = 6;
            $dataLength = $payloadLength + $payloadOffset;
        }

        /**
         * We have to check for large frames here. socket_recv cuts at 1024 bytes
         * so if websocket-frame is > 1024 bytes we have to wait until whole
         * data is transferd.
         */
        if (strlen($data) < $dataLength) {
            return false;
        }

        if ($isMasked) {
            for ($i = $payloadOffset; $i < $dataLength; $i++) {
                $j = $i - $payloadOffset;
                if (isset($data[$i])) {
                    $unmaskedPayload .= $data[$i] ^ $mask[$j % 4];
                }
            }
            $decodedData['payload'] = $unmaskedPayload;
        } else {
            $payloadOffset = $payloadOffset - 4;
            $decodedData['payload'] = substr($data, $payloadOffset);
        }

        return $decodedData;
    }

//пользовательские сценарии:

    public function onOpen($connect, $info)
    {
      //  echo "open OK<br />\n";
        //fwrite($connect, encode('Привет, мы соеденены'));
    }

    public function onClose($connect)
    {
      //  echo "close OK<br />\n";
    }

    public function onMessage($connect, $data)
    {
        $f = $this->decode($data);

        $massiv = json_decode($f['payload']);
        $fd = fopen("hello.txt", 'w') or die("не удалось создать файл");
        $str = $f['payload'];
        fwrite($fd, $str);
        fclose($fd);
        /*{"message":"ьуыыы","hash":"6096","site":"","admin":1,"my_company_id":"c4ca4238a0b923820dcc509a6f75849b","tip_message":1,"typ":12}*/
     if(isset($massiv->typ)) {
         if ($massiv->typ == 12) {
         //    var_dump($this->user).'<br>';
          //   echo  $massiv->message;
             if ($massiv->admin == 0) {

                 $datas['hash'] = $massiv->hash;
                 $datas['site'] = $massiv->site;
                 $datas['admin'] = $massiv->site;
                 $datas['message'] = $massiv->message;
                 $datas['typ'] = $massiv->typ;

              if(!in_array($massiv->message,['wistis_write','wistis_write_off'])){
                 $res=$this->send_mess_to_server($datas);


                 $res1=json_decode($res);

                  $datas['hiddenmes'] = $res1->mess_id;
                  $datas['tema_id'] = $res1->tema_id;
              }




                 if (isset($this->user[$massiv->my_company_id])) {
//echo '<br>send to admin<br>';
                     fwrite($this->user[$massiv->my_company_id], $this->encode(json_encode($datas)));
                 }


             } else {
           //      echo '<br>send to client<br>';
                 //  $client_id = explode('|', $massiv->message);
                 $data_m['tip_message'] = $massiv->tip_message;
                 $data_m['message'] = $massiv->message;
                 fwrite($this->user[$massiv->hash], $this->encode(json_encode($data_m)));



             }

         }else{
             if ($massiv->admin == 0) {

                 $datas['hash'] = $massiv->tema_id;
                 $datas['site'] = $massiv->site;
                 $datas['admin'] = $massiv->site;
                 $datas['message'] = $massiv->message;
                 $datas['typ'] = $massiv->typ;

                 $datas['hiddenmes'] = $massiv->mess_id;
                 $datas['tema_id'] = $massiv->tema_id;



                 if (isset($this->user[$massiv->my_company_id])) {
//echo '<br>send to admin<br>';
                     fwrite($this->user[$massiv->my_company_id], $this->encode(json_encode($datas)));
                 }


             }


         }
     }
    }

    public function send_mess_to_server($data)
    {

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, 'https://cloud.neiros.ru/send_chat');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "my_data=" . json_encode($data));
            $out = curl_exec($curl);


            curl_close($curl);
        }
        return $out;

    }


}

$myclass = new ExampleClass();

$myclass->test();