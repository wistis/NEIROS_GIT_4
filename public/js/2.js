if (!JSON) {
    var JSON;
    if (!JSON) {
        JSON = {}
    }
    (function () {
        function f(n) {
            return n < 10 ? "0" + n : n
        }

        if (typeof Date.prototype.toJSON !== "function") {
            Date.prototype.toJSON = function (key) {
                return isFinite(this.valueOf()) ? this.getUTCFullYear() + "-" + f(this.getUTCMonth() + 1) + "-" + f(this.getUTCDate()) + "T" + f(this.getUTCHours()) + ":" + f(this.getUTCMinutes()) + ":" + f(this.getUTCSeconds()) + "Z" : null
            };
            String.prototype.toJSON = Number.prototype.toJSON = Boolean.prototype.toJSON = function (key) {
                return this.valueOf()
            }
        }
        var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
            escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
            gap, indent,
            meta = {"\b": "\\b", "\t": "\\t", "\n": "\\n", "\f": "\\f", "\r": "\\r", '"': '\\"', "\\": "\\\\"}, rep;

        function quote(string) {
            escapable.lastIndex = 0;
            return escapable.test(string) ? '"' + string.replace(escapable, function (a) {
                var c = meta[a];
                return typeof c === "string" ? c : "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
            }) + '"' : '"' + string + '"'
        }

        function str(key, holder) {
            var i, k, v, length, mind = gap, partial, value = holder[key];
            if (value && typeof value === "object" && typeof value.toJSON === "function") {
                value = value.toJSON(key)
            }
            if (typeof rep === "function") {
                value = rep.call(holder, key, value)
            }
            switch (typeof value) {
                case"string":
                    return quote(value);
                case"number":
                    return isFinite(value) ? String(value) : "null";
                case"boolean":
                case"null":
                    return String(value);
                case"object":
                    if (!value) {
                        return "null"
                    }
                    gap += indent;
                    partial = [];
                    if (Object.prototype.toString.apply(value) === "[object Array]") {
                        length = value.length;
                        for (i = 0; i < length; i += 1) {
                            partial[i] = str(i, value) || "null"
                        }
                        v = partial.length === 0 ? "[]" : gap ? "[\n" + gap + partial.join(",\n" + gap) + "\n" + mind + "]" : "[" + partial.join(",") + "]";
                        gap = mind;
                        return v
                    }
                    if (rep && typeof rep === "object") {
                        length = rep.length;
                        for (i = 0; i < length; i += 1) {
                            if (typeof rep[i] === "string") {
                                k = rep[i];
                                v = str(k, value);
                                if (v) {
                                    partial.push(quote(k) + (gap ? ": " : ":") + v)
                                }
                            }
                        }
                    } else {
                        for (k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                v = str(k, value);
                                if (v) {
                                    partial.push(quote(k) + (gap ? ": " : ":") + v)
                                }
                            }
                        }
                    }
                    v = partial.length === 0 ? "{}" : gap ? "{\n" + gap + partial.join(",\n" + gap) + "\n" + mind + "}" : "{" + partial.join(",") + "}";
                    gap = mind;
                    return v
            }
        }

        if (typeof JSON.stringify !== "function") {
            JSON.stringify = function (value, replacer, space) {
                var i;
                gap = "";
                indent = "";
                if (typeof space === "number") {
                    for (i = 0; i < space; i += 1) {
                        indent += " "
                    }
                } else {
                    if (typeof space === "string") {
                        indent = space
                    }
                }
                rep = replacer;
                if (replacer && typeof replacer !== "function" && (typeof replacer !== "object" || typeof replacer.length !== "number")) {
                    throw new Error("JSON.stringify")
                }
                return str("", {"": value})
            }
        }
        if (typeof JSON.parse !== "function") {
            JSON.parse = function (text, reviver) {
                var j;

                function walk(holder, key) {
                    var k, v, value = holder[key];
                    if (value && typeof value === "object") {
                        for (k in value) {
                            if (Object.prototype.hasOwnProperty.call(value, k)) {
                                v = walk(value, k);
                                if (v !== undefined) {
                                    value[k] = v
                                } else {
                                    delete value[k]
                                }
                            }
                        }
                    }
                    return reviver.call(holder, key, value)
                }

                text = String(text);
                cx.lastIndex = 0;
                if (cx.test(text)) {
                    text = text.replace(cx, function (a) {
                        return "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4)
                    })
                }
                if (/^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) {
                    j = eval("(" + text + ")");
                    return typeof reviver === "function" ? walk({"": j}, "") : j
                }
                throw new SyntaxError("JSON.parse")
            }
        }
    }())
}
if (!String.prototype.trim) {
    (function () {
        var a = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
        String.prototype.trim = function () {
            return this.replace(a, "")
        }
    })()
}
(function (a6, r, aI) {
    var az = false, y = "47", bp = 42, m = a6.roistatHost, V = "0.2", E = "1.0", a0 = "roistat_visit",
        ad = "roistat_first_visit", bN = "roistat_phone", U = "roistat_referrer", bx = "roistat_marker",
        ap = "roistat_marker_old", bA = "roistat_referrer_old", aF = "roistat_ab", bj = "rs", s = "roistat",
        C = "leadhunter_expire", v = 5 * 60 * 60, aJ = "roistat_leadHunterEnabled", c = 7 * 24 * 60 * 60,
        br = {expires: c, path: "/"}, F = "roistat-promo", L = "roistat-phone", q = "roistat-phone-country",
        G = "roistat-phone-region", t = "roistat-phone-number", bH = "roistat-phone-tel", aN = "country", Z = "region",
        at = "number", aX = "tel", i = "roistat_call_tracking", z = "roistat-js-script",
        aD = "roistat_phone_replacement", au = "roistat_phone_script_data", bo = "roistat-visit-id",
        ae = "roistat_metrika_counter_id", f = "roistat_marker_from_referrer", aC = "roistat_emailtracking_email",
        a = "roistat_emailtracking_tracking_email", bJ = "roistat_proxy_forms", aQ = ["_ym_uid", "_ga"],
        bs = "roistat_isMultiDomain",
        bl = ["roistat_param1", "roistat_param2", "roistat_param3", "roistat_param4", "roistat_param5"],
        a1 = "roistat_debug";
    var bD = m.replace(/^cloud\./, "");
    var by = "collector." + bD;
    var aU = {callTrackingEnabled: true, callTrackingManual: false, jsonpRequestTimeout: 100};
    var a2 = {isVisitProcessed: false, visitFromUser: null, cookies: {}, pageParams: {}, source: {marker: null}};
    var bq = {onVisitProcessed: [], onCallTrackingPhoneReceived: []};
    if (a6.roistatAlreadyStarted) {
        if (typeof console !== "undefined" && console.log) {
            console.log("Call: roistat already started, skip")
        }
        return
    }
    a6.roistatAlreadyStarted = true;
    if (a6.roistatCookieDomain) {
        br.domain = a6.roistatCookieDomain
    }
    a6.roistat = {
        version: y,
        getSource: function () {
            return a2.source.marker
        },
        visit: null,
        getVisit: function () {
            return roistat.visit
        },
        setVisit: function (bR) {
            a2.visitFromUser = bR
        },
        registerOnVisitProcessedCallback: function (bR) {
            bi(bR)
        },
        registerOnCalltrackingPhoneReceivedCallback: function (bR) {
            aA(bR)
        },
        disableCallTracking: function () {
            aU.callTrackingEnabled = false
        },
        setCallTrackingManualMode: function () {
            aU.callTrackingManual = true
        },
        setJSONPRequestTimeout: function (bR) {
            aU.jsonpRequestTimeout = bR
        },
        callTracking: {enabled: 0, phone: "", sessionTime: 0, replacementClasses: "", phonePrefix: ""},
        emailtracking: {
            enabled: true, loaded: false, email: null, trackingEmail: null, refresh: function () {
                o("Warning: used emailtracking refresh before module init")
            }
        },
        leadHunter: {
            isEnabled: true,
            onBeforeAppear: null,
            onAfterAppear: null,
            onBeforeSubmit: null,
            onAfterSubmit: null,
            additionalNotifyEmail: null,
            form: {
                title: null,
                subTitle: null,
                thankYouText: null,
                buttonText: null,
                nameLabel: null,
                contactLabel: null,
                isNameRequired: false,
                autoShowTime: null
            }
        },
        page: {params: {}},
        proxyForms: {enabled: true, loaded: false, settings: []}
    };
    var bi = function (bR) {
        if (!a2.isVisitProcessed) {
            bq.onVisitProcessed.push(bR)
        } else {
            bR()
        }
    };
    var aA = function (bR) {
        bq.onCallTrackingPhoneReceived.push(bR)
    };
    var bm = function () {
        a2.isVisitProcessed = true;
        o("[Roistat] visit id set. Processing callbacks");
        var bS = bq.onVisitProcessed.length;
        for (var bR = 0; bR < bS; bR++) {
            bq.onVisitProcessed[bR]()
        }
        if (a6.roistatVisitCallback !== aI) {
            a6.roistatVisitCallback(a6.roistat.getVisit())
        }
    };
    var bE = function () {
        var bS = bq.onCallTrackingPhoneReceived.length;
        for (var bR = 0; bR < bS; bR++) {
            bq.onCallTrackingPhoneReceived[bR]()
        }
    };
    var I = function (bV, bU) {
        var bT = bV.className.split(" "), bS = false, bR;
        for (bR = 0; bR < bT.length; bR++) {
            if (bT[bR] === bU) {
                bS = true;
                break
            }
        }
        if (!bS) {
            bT.push(bU);
            bV.className = bT.join(" ")
        }
    };
    var aZ = function (bU, bT) {
        var bS = bU.className.split(" "), bR;
        for (bR = 0; bR < bS.length; bR++) {
            if (bS[bR] === bT) {
                bS.splice(bR, 1);
                bU.className = bS.join(" ");
                break
            }
        }
    };
    var S = function (bS) {
        try {
            return decodeURIComponent(bS)
        } catch (bT) {
            var bR;
            bR = n(bS);
            if (bR === null) {
                return bS
            }
            return bR
        }
    };
    var n = function (bV) {
        var bU = {
            "%E0": "%D0%B0",
            "%E1": "%D0%B1",
            "%E2": "%D0%B2",
            "%E3": "%D0%B3",
            "%E4": "%D0%B4",
            "%E5": "%D0%B5",
            "%B8": "%D1%91",
            "%E6": "%D0%B6",
            "%E7": "%D0%B7",
            "%E8": "%D0%B8",
            "%E9": "%D0%B9",
            "%EA": "%D0%BA",
            "%EB": "%D0%BB",
            "%EC": "%D0%BC",
            "%ED": "%D0%BD",
            "%EE": "%D0%BE",
            "%EF": "%D0%BF",
            "%F0": "%D1%80",
            "%F1": "%D1%81",
            "%F2": "%D1%82",
            "%F3": "%D1%83",
            "%F4": "%D1%84",
            "%F5": "%D1%85",
            "%F6": "%D1%86",
            "%F7": "%D1%87",
            "%F8": "%D1%88",
            "%F9": "%D1%89",
            "%FC": "%D1%8C",
            "%FB": "%D1%8B",
            "%FA": "%D1%8A",
            "%FD": "%D1%8D",
            "%FE": "%D1%8E",
            "%FF": "%D1%8F",
            "%C0": "%D0%90",
            "%C1": "%D0%91",
            "%C2": "%D0%92",
            "%C3": "%D0%93",
            "%C4": "%D0%94",
            "%C5": "%D0%95",
            "%A8": "%D0%81",
            "%C6": "%D0%96",
            "%C7": "%D0%97",
            "%C8": "%D0%98",
            "%C9": "%D0%99",
            "%CA": "%D0%9A",
            "%CB": "%D0%9B",
            "%CC": "%D0%9C",
            "%CD": "%D0%9D",
            "%CE": "%D0%9E",
            "%CF": "%D0%9F",
            "%D0": "%D0%A0",
            "%D1": "%D0%A1",
            "%D2": "%D0%A2",
            "%D3": "%D0%A3",
            "%D4": "%D0%A4",
            "%D5": "%D0%A5",
            "%D6": "%D0%A6",
            "%D7": "%D0%A7",
            "%D8": "%D0%A8",
            "%D9": "%D0%A9",
            "%DC": "%D0%AC",
            "%DB": "%D0%AB",
            "%DA": "%D0%AA",
            "%DD": "%D0%AD",
            "%DE": "%D0%AE",
            "%DF": "%D0%AF"
        };
        var bS = "";
        var bT = 0;
        while (bT < bV.length) {
            var bR = bV.substring(bT, bT + 3);
            if (Object.prototype.hasOwnProperty.call(bU, bR)) {
                bS += bU[bR];
                bT += 3
            } else {
                bS += bV.substring(bT, bT + 1);
                bT++
            }
        }
        try {
            return decodeURIComponent(bS)
        } catch (bW) {
            return null
        }
    };
    a6.roistatVersion = y;
    var aE, bd = true, bh = r.location.href, aq = "", aa = "", ax = new Date().getTime(), bw = false,
        bk = a6.roistatPhonePrefix ? a6.roistatPhonePrefix : "",
        bO = a6.roistatPhonePrefixBind ? a6.roistatPhonePrefixBind : "",
        x = a6.roistatCalltrackingScripts && a6.roistatCalltrackingScripts.join ? a6.roistatCalltrackingScripts.join(",") : "";
    var g, bI;
    g = a6.roistatGetCookie = function (bR) {
        var bS = r.cookie.match(new RegExp("(?:^|; )" + bR.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"));
        return bS ? S(bS[1]) : aI
    };
    bI = a6.roistatSetCookie = function (bU, bW, bT) {
        bT = bT || {};
        var bS = bT.expires;
        if (typeof bS == "number" && bS) {
            var bY = new Date();
            bY.setTime(bY.getTime() + bS * 1000);
            bS = bT.expires = bY
        }
        if (bS && bS.toUTCString) {
            bT.expires = bS.toUTCString()
        }
        bW = encodeURIComponent(bW);
        var bR = bU + "=" + bW;
        for (var bV in bT) {
            bR += "; " + bV;
            var bX = bT[bV];
            if (bX !== true) {
                bR += "=" + bX
            }
        }
        r.cookie = bR
    };
    var k = function (bU, bT) {
        var bS = bU.length;
        for (var bR = 0; bR < bS; bR++) {
            bT(bU[bR])
        }
    };
    var aw = function (bR, bT) {
        for (var bS in bR) {
            if (Object.prototype.hasOwnProperty.call(bR, bS)) {
                bT(bS, bR[bS])
            }
        }
    };
    var aB = function (bR) {
        return Object.prototype.toString.call(bR) === "[object Array]"
    };
    if (r.getElementsByClassName == aI) {
        r.getElementsByClassName = function (bS) {
            var bR = [];
            var bW = new RegExp("\\b" + bS + "\\b");
            var bV = this.getElementsByTagName("*");
            for (var bU = 0; bU < bV.length; bU++) {
                var bT = bV[bU].className;
                if (bW.test(bT)) {
                    bR.push(bV[bU])
                }
            }
            return bR
        }
    }
    var T = function () {
        return String.fromCharCode
    };
    var bn = function (bT) {
        var bR = "";
        for (var bS = 0; bS < bT.length; ++bS) {
            bR += T()(bp ^ bT.charCodeAt(bS))
        }
        return bR
    };
    var X = function (bR) {
        return encodeURIComponent(bn(a8.encode(bR)))
    };
    var a8 = {
        _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", encode: function (bT) {
            var bR = "";
            var b0, bY, bW, bZ, bX, bV, bU;
            var bS = 0;
            bT = a8._utf8_encode(bT);
            while (bS < bT.length) {
                b0 = bT.charCodeAt(bS++);
                bY = bT.charCodeAt(bS++);
                bW = bT.charCodeAt(bS++);
                bZ = b0 >> 2;
                bX = ((b0 & 3) << 4) | (bY >> 4);
                bV = ((bY & 15) << 2) | (bW >> 6);
                bU = bW & 63;
                if (isNaN(bY)) {
                    bV = bU = 64
                } else {
                    if (isNaN(bW)) {
                        bU = 64
                    }
                }
                bR = bR + this._keyStr.charAt(bZ) + this._keyStr.charAt(bX) + this._keyStr.charAt(bV) + this._keyStr.charAt(bU)
            }
            return bR
        }, decode: function (bT) {
            var bR = "";
            var b0, bY, bW;
            var bZ, bX, bV, bU;
            var bS = 0;
            bT = bT.replace(/[^A-Za-z0-9\+\/\=]/g, "");
            while (bS < bT.length) {
                bZ = this._keyStr.indexOf(bT.charAt(bS++));
                bX = this._keyStr.indexOf(bT.charAt(bS++));
                bV = this._keyStr.indexOf(bT.charAt(bS++));
                bU = this._keyStr.indexOf(bT.charAt(bS++));
                b0 = (bZ << 2) | (bX >> 4);
                bY = ((bX & 15) << 4) | (bV >> 2);
                bW = ((bV & 3) << 6) | bU;
                bR = bR + String.fromCharCode(b0);
                if (bV != 64) {
                    bR = bR + String.fromCharCode(bY)
                }
                if (bU != 64) {
                    bR = bR + String.fromCharCode(bW)
                }
            }
            bR = a8._utf8_decode(bR);
            return bR
        }, _utf8_encode: function (bS) {
            bS = bS.replace(/\r\n/g, "\n");
            var bR = "";
            for (var bU = 0; bU < bS.length; bU++) {
                var bT = bS.charCodeAt(bU);
                if (bT < 128) {
                    bR += String.fromCharCode(bT)
                } else {
                    if ((bT > 127) && (bT < 2048)) {
                        bR += String.fromCharCode((bT >> 6) | 192);
                        bR += String.fromCharCode((bT & 63) | 128)
                    } else {
                        bR += String.fromCharCode((bT >> 12) | 224);
                        bR += String.fromCharCode(((bT >> 6) & 63) | 128);
                        bR += String.fromCharCode((bT & 63) | 128)
                    }
                }
            }
            return bR
        }, _utf8_decode: function (bR) {
            var bT = "";
            var bV = 0;
            var bW = 0;
            var bU = 0;
            var bS = 0;
            while (bV < bR.length) {
                bW = bR.charCodeAt(bV);
                if (bW < 128) {
                    bT += String.fromCharCode(bW);
                    bV++
                } else {
                    if ((bW > 191) && (bW < 224)) {
                        bU = bR.charCodeAt(bV + 1);
                        bT += String.fromCharCode(((bW & 31) << 6) | (bU & 63));
                        bV += 2
                    } else {
                        bU = bR.charCodeAt(bV + 1);
                        bS = bR.charCodeAt(bV + 2);
                        bT += String.fromCharCode(((bW & 15) << 12) | ((bU & 63) << 6) | (bS & 63));
                        bV += 3
                    }
                }
            }
            return bT
        }
    };
    var aG = function () {
        return r[T()(99, 111, 111, 107, 105, 101)]
    };
    var N = function () {
        bL();
        var bR = {c: bB()};
        return X(JSON.stringify(bR))
    };
    var bB = function () {
        var bR = [];
        for (var bS in a2.cookies) {
            if (!Object.prototype.hasOwnProperty.call(a2.cookies, bS)) {
                continue
            }
            bR.push(bS + "=" + a2.cookies[bS])
        }
        return bR.join("; ")
    };
    var bL = function () {
        var bR = h();
        for (var bS in bR) {
            if (!Object.prototype.hasOwnProperty.call(bR, bS)) {
                continue
            }
            a2.cookies[bS] = bR[bS]
        }
    };
    var M = function (bR) {
        bI(bx, bR, br);
        a2.source.marker = bR
    };
    var J = function () {
        return g(bx)
    };
    var d = function () {
        aw(a6.roistat.page.params, function (bS, bR) {
            a2.pageParams[bS] = bR
        })
    };
    var h = function () {
        var bU = aG();
        var bV = bU.split("; ");
        var bR = {};
        for (var bT = 0; bT < bV.length; bT++) {
            var bY = bV[bT];
            if (bY === "") {
                continue
            }
            var bS = bY.split("=");
            if (bS.length < 2) {
                continue
            }
            var bX = bS[0].trim();
            var bW = bS[1].trim();
            bR[bX] = bW
        }
        return bR
    };
    var e = function () {
        return T()(104, 97, 115, 104)
    };
    var Y = function (bR) {
        return bR.split("http://").join("").split("https://").join("").split("#")[0].split("?")[0].split("www.").join("").replace(/\/+$/, "")
    };
    var aY = {
        isAvailable: function () {
            var bR = false;
            if (!a6.sessionStorage || !a6.sessionStorage.setItem || !a6.sessionStorage.getItem || !a6.sessionStorage.removeItem) {
                return bR
            }
            try {
                a6.sessionStorage.setItem("testKey", "testValue");
                bR = a6.sessionStorage.getItem("testKey") === "testValue";
                a6.sessionStorage.removeItem("testKey")
            } catch (bS) {
                return false
            }
            return bR
        }, remove: function (bR) {
            if (this.isAvailable()) {
                a6.sessionStorage.removeItem(bR)
            }
        }, setObject: function (bR, bS) {
            if (this.isAvailable()) {
                a6.sessionStorage.setItem(bR, JSON.stringify(bS))
            }
        }, getObject: function (bS) {
            var bR = null;
            if (this.isAvailable()) {
                bR = a6.sessionStorage.getItem(bS);
                bR = JSON.parse(bR)
            }
            return bR
        }, set: function (bR, bS) {
            if (this.isAvailable()) {
                a6.sessionStorage.setItem(bR, bS)
            }
        }, get: function (bS) {
            var bR = null;
            if (this.isAvailable()) {
                bR = a6.sessionStorage.getItem(bS)
            }
            return bR
        }
    };
    var a4 = {
        isAvailable: function () {
            var bR = false;
            if (!a6.localStorage || !a6.localStorage.setItem || !a6.localStorage.getItem || !a6.localStorage.removeItem) {
                return bR
            }
            try {
                a6.localStorage.setItem("testKey", "testValue");
                bR = a6.localStorage.getItem("testKey") === "testValue";
                a6.localStorage.removeItem("testKey")
            } catch (bS) {
                return false
            }
            return bR
        }, remove: function (bS) {
            if (this.isAvailable()) {
                a6.localStorage.removeItem(bS)
            } else {
                var bR = new Date(1970, 1, 1);
                bI(bS, "", {expires: bR.toUTCString()})
            }
        }, setObject: function (bR, bS) {
            if (this.isAvailable()) {
                localStorage.setItem(bR, JSON.stringify(bS))
            }
        }, getObject: function (bS) {
            var bR = null;
            if (this.isAvailable()) {
                bR = localStorage.getItem(bS);
                bR = JSON.parse(bR)
            }
            return bR
        }, set: function (bR, bS) {
            if (this.isAvailable()) {
                localStorage.setItem(bR, bS)
            } else {
                bI(bR, bS, br)
            }
        }, save: function (bS, bT, bR) {
            if (this.isAvailable()) {
                localStorage.setItem(bS, bT)
            }
            bI(bS, bT, bR)
        }, get: function (bS) {
            var bR = null;
            if (this.isAvailable()) {
                bR = localStorage.getItem(bS)
            }
            if (bR === null) {
                bR = g(bS)
            }
            return bR
        }
    };
    var aW = function () {
        var bR = null;
        var bS = a4.get(U);
        var bT = af(bS) ? bS : r.referrer;
        if (bT) {
            bR = bT
        }
        return bR
    };
    var af = function (bR) {
        return typeof bR === "string"
    };
    var A = function (bU, bT) {
        bT = typeof bT !== "undefined" ? bT : false;
        var bV = function (bY) {
            var bX = null;
            var bZ = new RegExp("[#&?](" + bU + "=[^#&?]+)");
            if (bZ.test(bY)) {
                bX = RegExp.$1.substring(RegExp.$1.indexOf("=") + 1)
            }
            var bW = S(bX);
            return bX && bW ? bW : bX
        };
        var bR = bV(bh);
        if (bT) {
            var bS = r.referrer;
            if (bR === null && bS) {
                bR = bV(bS)
            }
        }
        return bR
    };
    var bC = function (bS, bT) {
        var bR = false;
        if (bS && bT) {
            bR = bS.split(bT).join("") !== bS
        }
        return bR
    };
    if (A(a1) === "1" || h()[a1] === "1") {
        az = true
    }
    var am = function () {
        if ("https:" === r.location.protocol) {
            return "https:"
        } else {
            return "http:"
        }
    };
    var bg = function (bS, bX, bY) {
        var bU = r.createElement("iframe");
        var bW = "roistat_" + new Date().getTime();
        r.body.appendChild(bU);
        bU.style.display = "none";
        bU.setAttribute("name", bW);
        bU.setAttribute("id", bW);
        bU.contentWindow.name = bW;
        var bV = r.createElement("form");
        bV.target = bW;
        bV.action = bS;
        bV.method = bY;
        for (var bT in bX) {
            if (!Object.prototype.hasOwnProperty.call(bX, bT)) {
                continue
            }
            var bR = r.createElement("input");
            bR.type = "hidden";
            bR.name = bT;
            bR.value = bX[bT];
            bV.appendChild(bR)
        }
        r.body.appendChild(bV);
        bV.submit()
    };
    var ac = function (bS) {
        o("sendApiRequestJSONP: init with url " + bS);
        var bR = r.createElement("script");
        bR.onload = bR.onreadystatechange = function () {
            var bU = this.readyState ? this.readyState : "unknown";
            o("sendApiRequestJSONP: script state changed to " + bU)
        };
        bR.src = bS;
        bR.type = "text/javascript";
        bR.async = true;
        var bT = r.getElementsByTagName("script")[0];
        bT.parentNode.insertBefore(bR, bT);
        o("sendApiRequestJSONP: script appended")
    };
    var bf = function () {
        var bS = r.createElement("link"), bR = r.getElementsByTagName("head");
        bS.setAttribute("rel", "stylesheet");
        bS.setAttribute("href", am() + "//" + m + "/dist/module.css?" + y);
        if (bR.length > 0) {
            bR[0].appendChild(bS)
        }
    };
    var ba = function () {
        return bc() || bP()
    };
    var bc = function () {
        return ar() !== null
    };
    var bP = function () {
        return a7() !== null
    };
    var bv = function () {
        var bR = bt();
        if (bR !== null) {
            bI(a0, bR, br)
        }
    };
    var bt = function () {
        return ar() || a7() || null
    };
    var ar = function () {
        return A("roistat_visit")
    };
    var a7 = function () {
        return a2.visitFromUser
    };
    var bM = function () {
        o("Call: Init");
        o("Counter version: " + y);
        if (A("roistat_ab_demo") === "1") {
            o("Roistat initialisation rejected: ab test preview mode");
            return
        }
        bf();
        av();
        B();
        if (!K() || bQ()) {
            bw = true;
            aK()
        } else {
            bv();
            aO();
            ak();
            bu();
            roistat.visit = j();
            a2.source.marker = J();
            bm()
        }
        bF();
        H()
    };
    var av = function () {
        o("Call: initMarker");
        aE = bb();
        o("Call: inited marker: " + aE)
    };
    var aV = function (bT) {
        if (!bT) {
            return true
        }
        var bR = aj(bT);
        var bS = aj(r.domain);
        if (bR === bS) {
            return true
        }
        var bU = aT();
        if (bU === null) {
            return false
        }
        if (bC(bR, bU) && bC(bS, bU)) {
            return true
        }
        return false
    };
    var aT = function () {
        if (typeof br.domain === "string" && br.domain !== "") {
            return aj(br.domain)
        }
        return null
    };
    var aj = function (bR) {
        var bS = bR.split("http://").join("").split("https://").join("").split("www.").join("");
        return bS.split("/")[0]
    };
    var bb = function () {
        var bU = g(f) > 0;
        var bY = null;
        var bS = function (bZ) {
            return bZ.split("_").join(":u:")
        };
        var bV = function () {
            var bZ = false;
            var b0;
            b0 = A(s, bU);
            if (b0 !== null) {
                bY = b0;
                bZ = true
            }
            b0 = A(bj, bU);
            if (b0 !== null) {
                bY = b0;
                bZ = true
            }
            return bZ
        };
        var bX = function () {
            var bZ = false;
            var b0 = J();
            if (b0) {
                bY = b0;
                bZ = true;
                bd = false
            }
            return bZ
        };
        var bT = function () {
            var bZ = false;
            var b1 = A("utm_source", bU);
            if (b1 !== null) {
                bZ = true;
                bY = ":utm:" + bS(b1);
                var b3 = ["utm_medium", "utm_campaign", "utm_content", "utm_term"];
                var b0;
                for (var b2 = 0; b2 < b3.length; b2++) {
                    b0 = A(b3[b2], bU);
                    if (b0 !== null) {
                        bY = bY + "_" + bS(b0)
                    }
                }
            }
            return bZ
        };
        var bW = function () {
            var b1, b0, bZ = false;
            b0 = A("_openstat", bU);
            if (!b0) {
                return false
            }
            if (bC(b0, ";")) {
                b1 = b0
            } else {
                b1 = encodeURI(a8.decode(b0))
            }
            if (b1) {
                b1 = bS(b1).split(";").join("_");
                bY = ":openstat:" + b1;
                bZ = true
            }
            return bZ
        };
        var bR = function () {
            var bZ = false;
            var b0 = r.referrer;
            if (aV(b0)) {
                return bZ
            }
            var b1 = A("from", bU);
            if (b1 !== null && !bC(b1, "http")) {
                bZ = true;
                bY = bS(b1)
            }
            return bZ
        };
        if (bV()) {
            o("Init marker: init from RS param " + bY);
            return bY
        }
        if (bT()) {
            o("Init marker: init from UTM " + bY);
            return bY
        }
        if (bW()) {
            o("Init marker: init from OpenStat " + bY);
            return bY
        }
        if (bR()) {
            o("Init marker: init from custom tag " + bY);
            return bY
        }
        o("Init marker: try init from cookie " + bY);
        bX();
        return bY
    };
    var j = function () {
        return a4.get(a0)
    };
    var B = function () {
        o("Call: saveReferrer");
        var bR = r.referrer;
        if (aV(bR)) {
            return
        }
        a4.set(U, bR)
    };
    var bF = function () {
        bI(ap, S(aE), br)
    };
    var H = function () {
        a4.set(bA, aW())
    };
    var bu = function () {
        o("Call: refreshPromoCode");
        var bR = function () {
            return g(a0)
        };
        Q(bR());
        if (!a6.onload) {
            a6.onload = function () {
                Q(bR())
            }
        }
        setTimeout(function () {
            Q(bR())
        }, 50);
        setTimeout(function () {
            Q(bR())
        }, 200);
        setTimeout(function () {
            Q(bR())
        }, 2000);
        setTimeout(function () {
            Q(bR())
        }, 10000)
    };
    a6.roistatPromoCodeRefresh = bu;
    var bG = function () {
        var bR = [];
        var bS = r.getElementsByClassName(F);
        if (bS && bS.length) {
            bR = bS
        }
        return bR
    };
    var Q = function (bR) {
        var bU = bG();
        o("setPromoCode: " + bR + " in " + bU.length + " elements");
        for (var bT = 0; bT < bU.length; bT++) {
            var bS = bU[bT];
            bS.innerHTML = bR ? bR : ""
        }
    };
    var aL = function () {
        var bT = bb(), bS = g(ap), bV = bT !== null, bU = true;
        var bX = S(S(bT)).toLowerCase().split("+").join(" "), bW = S(S(bS)).toLowerCase().split("+").join(" ");
        if (bT && bS) {
            bU = bX !== bW
        }
        var bR = bV && bU;
        aa = "Call: needOverrideByMarker (result " + (bR ? "true" : "false") + ") with current " + bT + ":" + bX + " and old " + bS + ":" + bW;
        o(aa);
        return bR
    };
    var W = function () {
        var bS = function (b0) {
            return /[\u0400-\u04FF]/.test(b0)
        };
        var bZ = false, bW = aW(), bR = a4.get(bA), bY = a6.location.host;
        if (!bW || !bY) {
            o("Call: needOverrideByReferrer (result " + (bZ ? "true" : "false") + "), skip because one of params is empty");
            return bZ
        }
        bY = aj(bY);
        bW = S(bW);
        bR = S(bR);
        var bU = aj(bW);
        if (bC(bW, "xn--") && bS(bY)) {
            o("Call: needOverrideByReferrer (result " + (bZ ? "true" : "false") + "), skip because of bugs with punycode in FF");
            return bZ
        }
        if (!bU) {
            o("Call: needOverrideByReferrer (result " + (bZ ? "true" : "false") + "), skip because current referrer is null");
            return bZ
        }
        if (!bR) {
            bZ = !bC(bU, bY);
            o("Call: needOverrideByReferrer (result " + (bZ ? "true" : "false") + "), compare current referrer and host");
            return bZ
        }
        if (bC(bW, bR)) {
            o("Call: needOverrideByReferrer (result " + (bZ ? "true" : "false") + "), skip because the same referrer");
            return bZ
        }
        var bX = bY.split(".").length > 2 && bU.split(".").length > 2;
        var bV = a6.roistatCookieDomain !== aI && a6.roistatCookieDomain !== bY;
        var bT = bU.split(".").slice(1).join(".") === bY.split(".").slice(1).join(".");
        if (bX && bV && bT) {
            o("Call: needOverrideByReferrer (result " + (bZ ? "true" : "false") + "), skip because sub domains of same domain");
            return bZ
        }
        bZ = !(bC(bU, bY) || (bC(bY, bU)));
        o("Call: needOverrideByReferrer (result " + (bZ ? "true" : "false") + ") referrerHost: " + bU + ", currentHost: " + bY);
        return bZ
    };
    var aP = function () {
        return A("utm_nooverride") === "1"
    };
    var bQ = function () {
        return !ba() && !aP() && (aL() || W())
    };
    var aR = function (bS, bR) {
        return (bS && bR && bS != bR)
    };
    var an = function (bT) {
        var bR = ["cookieExpire"];
        var bV = bT.leadHunterEnabled;
        if (!bV) {
            if (a4.get(aJ) > 0) {
                a4.set(aJ, 0)
            }
        } else {
            var bU = {expires: v, path: "/"};
            if (br.domain) {
                bU.domain = br.domain
            }
            bI(C, 1, bU)
        }
        for (var bS in bT) {
            if (!Object.prototype.hasOwnProperty.call(bT, bS)) {
                continue
            }
            if (!bV && bS.indexOf("leadHunter") >= 0) {
                continue
            }
            if (!P(bR, bS)) {
                a4.set("roistat_" + bS, bT[bS])
            }
        }
    };
    a6.roistatModuleSetVisitCookie = function (bV, b1, bU, bS, b0, bR) {
        o("Call: roistatModuleSetVisitCookie(" + bV + ")");
        var bX;
        if (typeof bU.cookieExpire !== "number") {
            bX = c
        } else {
            bX = bU.cookieExpire
        }
        var bW = g(a0);
        var bZ = {expires: bX, path: "/"};
        if (br.domain) {
            bZ.domain = br.domain
        }
        bI(a0, bV, bZ);
        if (!(g(a0) > 0)) {
            a4.save(a0, bV, bZ)
        }
        if (!a4.get(ad)) {
            var bT = {expires: 10 * 365 * 24 * 60 * 60, path: "/"};
            if (br.domain) {
                bT.domain = br.domain
            }
            a4.save(ad, bV, bT)
        }
        var bY = bU.abTests;
        if ((typeof bY !== "undefined") && a4.isAvailable()) {
            a4.setObject("abTesting", bY)
        }
        applyTests();
        Q(bV);
        if (b1) {
            M(b1);
            bI(ap, b1, br)
        }
        an(bU);
        o("Call: pre renderPromoCode");
        ak();
        bu();
        if (aR(bW, bV)) {
            o("roistatModuleSetVisitCookie: visit changed from " + bW + " to " + bV)
        }
        if (a6.roistatCallback !== aI) {
            a6.roistatCallback(bV, b1)
        }
        roistat.visit = bV;
        roistat.callTracking.enabled = bS.enabled;
        roistat.callTracking.phone = bS.phone;
        roistat.callTracking.sessionTime = bS.sessionTime;
        roistat.callTracking.replacementClasses = bS.replacementClasses;
        roistat.callTracking.phoneScriptsJson = bS.scripts;
        roistat.emailtracking.loaded = true;
        roistat.emailtracking.email = b0.email;
        roistat.emailtracking.trackingEmail = b0.trackingEmail;
        roistat.proxyForms.loaded = true;
        roistat.proxyForms.settings = bR;
        bE();
        bm()
    };
    var K = function () {
        var bR;
        if (a6.roistatIsInitVisit === true) {
            bR = false
        } else {
            bR = g(a0) > 0
        }
        o("Call: alreadyVisited (return " + (bR ? "true" : "false") + ")");
        return bR
    };
    var b = function (bR) {
        return encodeURIComponent ? encodeURIComponent(bR) : encodeURI(bR)
    };
    var ag = function () {
        var bR = aW();
        return bR ? b(bR) : ""
    };
    var ai = function () {
        return a6.roistatProjectId
    };
    var w = function () {
        return am() + "//" + m + "/api/site/" + E + "/" + ai()
    };
    var be = function () {
        var bR = {expires: 1, path: "/"};
        if (br.domain) {
            bR.domain = br.domain
        }
        bI(aF, "", bR)
    };
    var aK = function () {
        o("Call: setVisitIdCookie");
        var bS = function () {
            var b0 = ai(), bX = ag(), bU = a6.roistatIsInitVisit === true ? j() : 0, bZ = g(aF), bV = a4.get(ad);
            bZ = bZ ? bZ : "";
            bV = bV ? bV : "";
            aE = aE && (!W() || bd) ? S(S(aE)) : "";
            var bY = encodeURIComponent(bh);
            o("Calltracking: enabled=" + aU.callTrackingEnabled + ",manual=" + aU.callTrackingManual);
            var bW = JSON.stringify(a6.roistat.page.params);
            return w() + "/addVisit?v=" + y + "&marker=" + encodeURIComponent(aE) + "&visit=" + bU + "&first_visit=" + bV + "&phone_prefix=" + bk + "&phone_prefix_bind=" + bO + "&phone_scripts_bind=" + x + "&referrer=" + bX + "&page=" + bY + "&ab=" + b(bZ) + "&" + e() + "=" + N() + (bW === "{}" ? "" : "&page_params=" + encodeURIComponent(bW)) + ((!aU.callTrackingEnabled || aU.callTrackingManual) ? "&call_tracking_disabled=1" : "")
        };
        var bR = function (bU) {
            setTimeout(function () {
                o("Call: setVisitIdCookie script creation after timeout");
                var bV = r.createElement("script");
                bV.onload = bV.onreadystatechange = function () {
                    var bX = this.readyState ? this.readyState : "unknown";
                    o("Call: setVisitIdCookie script state changed to " + bX)
                };
                bV.src = bU;
                bV.type = "text/javascript";
                bV.async = true;
                bV.id = z;
                var bW = r.getElementsByTagName("script")[0];
                bW.parentNode.insertBefore(bV, bW);
                o("Call: setVisitIdCookie appended " + ((r.getElementById(z)) ? "true" : "false"));
                o("Call: sendJSONPRequest to URL " + bU);
                be()
            }, aU.jsonpRequestTimeout)
        };
        if (aE) {
            M(aE)
        }
        var bT = bS();
        bR(bT)
    };
    var aO = function () {
        o("Call: sendAbTests");
        var bS = function () {
            var bW = ai(), bV = g(a0);
            return am() + "//" + m + "/site-api/" + V + "/" + bW + "/visit/" + bV + "/addAbVariant"
        };
        var bT = g(aF);
        if (!bT) {
            return
        }
        var bU = bS();
        bU = bU + "?ab=" + b(bT);
        var bR = r.createElement("img");
        bR.src = bU;
        be()
    };
    var ab = {
        Android: function () {
            return navigator.userAgent.match(/Android/i)
        }, BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i)
        }, iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i)
        }, Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i)
        }, Windows: function () {
            return navigator.userAgent.match(/IEMobile/i)
        }, any: function () {
            return (ab.Android() || ab.BlackBerry() || ab.iOS() || ab.Opera() || ab.Windows())
        }
    };
    var ah = {
        isIE: function (bT, bV) {
            var bW = "IE", bS = r.createElement("B"), bR = r.documentElement, bU;
            if (bT) {
                bW += " " + bT;
                if (bV) {
                    bW = bV + " " + bW
                }
            }
            bS.innerHTML = "<!--[if " + bW + ']><b id="iecctest"></b><![endif]-->';
            bR.appendChild(bS);
            bU = !!r.getElementById("iecctest");
            bR.removeChild(bS);
            return bU
        }
    };
    var a9 = function () {
        return new Date().getTime()
    };
    var D = function () {
        var bR = "";
        a6.onerror = function (bX, bW, bT, bV, bU) {
            var bS = !bV ? "" : ", column: " + bV;
            bS += !bU ? "" : ", error: " + bU;
            bR = bR + ", Error: " + bX + ", url: " + bW + ", line: " + bT + bS
        };
        setTimeout(function () {
            var bZ = false, b0 = "";
            var bV = bG();
            for (var bY = 0; bY < bV.length; bY++) {
                var bU = bV[bY];
                if (bU !== null && !bU.innerHTML) {
                    bZ = true;
                    b0 = "Promo HTML: " + bU.innerHTML
                }
            }
            if (!(g(a0) > 0)) {
                bZ = true;
                b0 = b0 + "; roistat_visit = " + g(a0)
            }
            if (bZ) {
                var bT = r.getElementById(z);
                var bS = bT ? 1 : 0;
                var bW = a6.navigator.userAgent;
                b0 = encodeURIComponent(b0);
                var bX = r.createElement("img");
                bX.src = am() + "//" + m + "/site-api/" + V + "/" + ai() + "/debug?message=" + b0 + "&agent=" + bW + "&" + e() + "=" + N() + "&jserror=" + bR + "&scriptResponse=" + bS + "&version=" + y + "&debug=" + aq
            }
        }, 20000)
    };
    var aH = function () {
        var bT = r.getElementsByTagName("body");
        var bU = r.documentElement;
        var bS = 0, bV = 0;
        if (bT.length) {
            var bR = bT[0];
            bS = a6.innerWidth || bU.clientWidth || bR.clientWidth;
            bV = a6.innerHeight || bU.clientHeight || bR.clientHeight
        } else {
            bS = a6.innerWidth || bU.clientWidth;
            bV = a6.innerHeight || bU.clientHeight
        }
        return {width: bS, height: bV}
    };
    var ak = function () {
        var bW = r.getElementsByClassName("roistat-promo-wrap");
        if (bW.length) {
            o("PromoCode: old promo code length - exit");
            return
        }
        var bU = function () {
            var b3 = r.createElement("div");
            b3.innerHTML = roistatPromoCode;
            var b1 = r.getElementsByTagName("body");
            if (b1.length) {
                b1[0].appendChild(b3)
            }
            o("PromoCode: appended to body " + roistatPromoCode.length);
            var b2 = r.getElementsByClassName("roistat-promo-wrap")[0];
            if (!b2) {
                o("PromoCode: roistat-promo-wrap not found, skip");
                return
            }
            var b0 = b2.style;
            var bY, bZ, bX;
            setInterval(function () {
                bY = aH();
                bZ = b2.offsetWidth;
                bX = b2.offsetHeight * 2;
                switch (roistatPosition) {
                    case"top_left":
                        b0.left = 0;
                        b0.top = 0;
                        break;
                    case"top":
                        b0.left = ((bY.width - bZ) / 2) + "px";
                        b0.top = 0;
                        break;
                    case"top_right":
                        b0.right = 0;
                        b0.top = 0;
                        break;
                    case"left":
                        b0.left = 0;
                        b0.top = ((bY.height - bX) / 2) + "px";
                        break;
                    case"right":
                        b0.right = 0;
                        b0.top = ((bY.height - bX) / 2) + "px";
                        break;
                    case"bottom_left":
                        b0.left = 0;
                        b0.bottom = 0;
                        break;
                    case"bottom":
                        b0.left = ((bY.width - bZ) / 2) + "px";
                        b0.bottom = 0;
                        break;
                    case"bottom_right":
                        b0.right = 0;
                        b0.bottom = 0;
                        break;
                    default:
                        b0.left = 0;
                        b0.top = 0
                }
            }, 500)
        };
        var bR = a4.getObject("promo_code_options");
        if (bR) {
            a6.roistatPromoCode = bR.template;
            a6.roistatPosition = bR.position;
            bU()
        } else {
            var bV = r.getElementsByTagName("head")[0] || r.documentElement;
            var bT = r.createElement("script");
            bT.src = am() + "//" + m + "/site-api/" + V + "/" + ai() + "/getPromoCode";
            bV.insertBefore(bT, bV.firstChild);
            o("PromoCode: loading started");
            var bS = false;
            bT.onload = bT.onreadystatechange = function () {
                if (!bS && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                    bS = true;
                    bT.onload = bT.onreadystatechange = null;
                    if (bV && bT.parentNode) {
                        bV.removeChild(bT)
                    }
                }
                if (!bS) {
                    return
                }
                o("PromoCode: loaded");
                if (typeof roistatPromoCode === "undefined" || roistatPromoCode.length < 1) {
                    o("PromoCode: is disabled");
                    return
                }
                bR = {template: roistatPromoCode, position: roistatPosition};
                a4.setObject("promo_code_options", bR);
                bU()
            }
        }
    };
    var P = function (bS, bT) {
        for (var bR = 0; bR < bS.length; bR++) {
            if (bS[bR] === bT) {
                return true
            }
        }
        return false
    };
    var o = function (bS) {
        var bT = a9() - ax;
        var bR = "[" + (bT / 1000) + "s] " + bS;
        aq = aq + "; " + bR;
        if (typeof console !== "undefined" && console.log && az) {
            console.log(bR)
        }
    };
    (function aM() {
        if (a6.onRoistatModuleLoaded !== aI && typeof a6.onRoistatModuleLoaded === "function") {
            a6.onRoistatModuleLoaded()
        }
    })();
    bM();
    (function al() {
        var da = "roistat-lh-form", b9 = "roistat-lh-form", dc = "roistat-lh-head-text", ck = "roistat-lh-head",
            b7 = "roistat-lh-thank-you", cH = "roistat-lh-thank-you", bU = "roistat-lh-close", bV = "roistat-lh-submit",
            cr = "roistat-lh-hidden", cY = "roistat-lh-wrap", cG = "roistat-lh-popup", db = "roistat-lh-agreement",
            cB = "roistat-lh-agreement roistat-lh-mobile", dl = "roistat-lh-agreement-input",
            c4 = "roistat-lh-agreement-link", bR = "roistat-lh-agreement-doc", c8 = "roistat-lh-alert-row",
            cM = "roistat-lh-agreement", cO = "roistat_leadHunterUrl", c6 = "roistat_leadHunterAppearanceUrl",
            cv = "roistat_leadHunterTargetPagesList", b5 = "roistat_leadHunterCaught",
            cd = "roistat_leadHunterFormTemplate_{version}", cS = 14, cl = "roistat_leadHunterPulsatorTemplate",
            cR = "roistat_leadHunterMinTime", co = "roistat_leadHunterAutoShowTime",
            cQ = "roistat_leadHunterPulsatorEnabled";
        var b4 = 0.3, ce = 0.001, b8 = false, ch = 0, cb = 0, ci = 0, de = 0, cg = 0, cD = false, ct = false,
            bY = false, cf, cN, cX, cj, dk, dh, c5, dj, b0, df, cV, cI, cA, b3, bT, cq;
        var di = {pulsator: {previousClass: ""}, leave: {isShowEnabled: false,}, timeoutId: 0};
        var cc = function () {
            return cd.split("{version}").join(cS)
        };
        var dd = function (dr) {
            var dq = encodeURIComponent ? encodeURIComponent : encodeURI;
            return dq(dr)
        };
        var b6 = function () {
            if (!a4.isAvailable()) {
                return
            }
            a4.remove(cd.split("_{version}").join(""));
            var dq;
            if (cS > 1) {
                for (dq = 1; dq < cS; dq++) {
                    a4.remove(cd.split("{version}").join(dq.toString()))
                }
            }
        };
        var c0 = function () {
            if (!a6.roistat.leadHunter.isEnabled) {
                return false
            }
            if (a6.roistatLeadHunterInited) {
                return false
            }
            a6.roistatLeadHunterInited = true;
            if (a4.get(aJ) < 1) {
                o("LeadHunter: disabled");
                return false
            }
            return true
        };
        var cs = function () {
            bT = a4.get(cO);
            if (!bT) {
                o("LeadHunter: not active cause of empty url");
                return false
            }
            cq = a4.get(c6);
            de = a4.get(cR);
            cg = a6.roistat.leadHunter.form.autoShowTime === null ? a4.get(co) : a6.roistat.leadHunter.form.autoShowTime;
            cD = a4.get(cQ) == 1;
            bS();
            return true
        };
        var bS = function () {
            if (a4.get(b5) > 0) {
                o("LeadHunter: not active because already caught");
                ct = true
            }
            if (!(g(C) > 0)) {
                o("LeadHunter: not active, expired for this visit");
                ct = true
            }
        };
        var dp = function () {
            var dw = function (dD, dB) {
                var dA;
                if (bC(dB, "*")) {
                    var dC = new RegExp(dB.split("*").join(".*"));
                    dA = dC.test(dD)
                } else {
                    dA = dD === dB
                }
                o("LeadHunter: compare current: " + dD + ", setting: " + dB + " with result = " + (dA ? 1 : 0));
                return dA
            };
            var dr = a4.get(cv), dq = a6.location.href, dt = false, ds = false, dy = "", du = 0, dx;
            dx = dr ? dr.split(",") : [];
            if (!dq || dx.length === 0) {
                dt = true
            } else {
                dy = Y(dq);
                var dz;
                for (var dv = 0; dv < dx.length; dv++) {
                    dz = dx[dv].split("www.").join("").split("http://").join("").split("https://").join("").replace(/\/+$/, "");
                    if (/^!/.test(dz)) {
                        if (dw(dy, dz.split(/^!/).join(""))) {
                            ds = true;
                            break
                        }
                    } else {
                        du++;
                        if (dw(dy, dz)) {
                            dt = true;
                            break
                        }
                    }
                }
            }
            if (ds) {
                o('LeadHunter: current page "' + dy + '" is disabled by list');
                return false
            }
            if (!dt && du > 0) {
                o('LeadHunter: current page "' + dy + '" is not listed');
                return false
            }
            o('LeadHunter: current page "' + dq + '", cleaned: "' + dy + '" is not disabled in ' + dx.length + " list of pages");
            return true
        };
        var cz = function () {
            bY = true;
            bX("click");
            cW()
        };
        var bW = function () {
            var dq = a6.location.hash;
            if (!dq) {
                return
            }
            if (bC(dq, "roistat-lead-hunter")) {
                cz()
            }
        };
        var cx = function b2() {
            o("LeadHunter: binding timeout");
            if (ct) {
                o("LeadHunter: leadhunter is expired, no timeout show allowed");
                return
            }
            if (b8) {
                o("LeadHunter: leadhunter was shown, no timeout show allowed");
                return
            }
            if (cg > 0) {
                var dq = (ch - a9()) + cg * 1000;
                o("LeadHunter: binding timeout with delay " + dq + " ms");
                clearTimeout(di.timeoutId);
                di.timeoutId = setTimeout(function () {
                    o("LeadHunter: form auto activate with autoTime = " + cg);
                    if (!b8) {
                        bY = true;
                        bX("auto");
                        cW()
                    }
                }, dq)
            } else {
                o("LeadHunter: auto show time is not positive, feature disabled")
            }
        };
        var c7 = function () {
            function dv(dy, dx, dw) {
                if (dy.addEventListener) {
                    dy.addEventListener(dx, dw, false)
                } else {
                    if (dy.attachEvent) {
                        dy.attachEvent("on" + dx, dw)
                    } else {
                        o("Handler could not be attached")
                    }
                }
            }

            c5.onclick = cX.onclick = cK;
            dj.onclick = cu;
            if (df) {
                dv(df, "click", cC)
            }
            if (cV) {
                dv(cV, "change", dm)
            }
            var dr = r.getElementsByClassName("roistat-lh-input");
            for (var du = 0; du < dr.length; du++) {
                dv(dr[du], "keyup", function (dx) {
                    dx = dx || event;
                    var dw = (dx.keyCode ? dx.keyCode : dx.which);
                    if (dw == 13) {
                        cu()
                    }
                })
            }
            var ds = a6.onresize;
            a6.onresize = function (dw) {
                if (ds) {
                    ds(dw)
                }
                c9(dw)
            };
            if (!ct) {
                var dq = r.onmouseout;
                r.onmouseout = function (dw) {
                    if (dq) {
                        dq(dw)
                    }
                    cU(dw)
                }
            }
            if (cD) {
                cf.onmouseover = function () {
                    I(cf, "roistat-lh-pulsator-hover")
                };
                cf.onmouseout = function () {
                    aZ(cf, "roistat-lh-pulsator-hover")
                };
                cf.onclick = function () {
                    cz()
                }
            }
            var dt = a6.onhashchange;
            a6.onhashchange = function () {
                if (dt) {
                    dt.apply(this, arguments)
                }
                bW()
            }
        };
        var cJ = function () {
            var dt = function (dy) {
                var dx = r.getElementsByClassName(dy);
                if (dx.length > 0) {
                    return dx[0]
                } else {
                    return null
                }
            };
            var du = dt("roistat-lh-title");
            if (du && roistat.leadHunter.form.title) {
                du.innerHTML = roistat.leadHunter.form.title
            }
            var dr = dt("roistat-lh-sub-title");
            if (dr && roistat.leadHunter.form.subTitle) {
                dr.innerHTML = roistat.leadHunter.form.subTitle
            }
            var ds = dt("roistat-lh-thank-you");
            if (ds && roistat.leadHunter.form.thankYouText) {
                ds.innerHTML = roistat.leadHunter.form.thankYouText
            }
            var dw = dt("roistat-lh-submit");
            if (dw && roistat.leadHunter.form.buttonText) {
                dw.value = roistat.leadHunter.form.buttonText
            }
            var dv = dt("roistat-lh-text-label-name");
            if (dv && roistat.leadHunter.form.nameLabel) {
                dv.innerHTML = roistat.leadHunter.form.nameLabel
            }
            var dq = dt("roistat-lh-text-label-contact");
            if (dq && roistat.leadHunter.form.contactLabel) {
                dq.innerHTML = roistat.leadHunter.form.contactLabel
            }
        };
        var ca = function (dr, ds) {
            var dq;
            if (!dr) {
                o("LeadHunter: deactivating, empty form")
            } else {
                o("LeadHunter: rendering hidden form")
            }
            if (a4.isAvailable()) {
                c1(dr, ds)
            }
            cX = r.createElement("div");
            cN = r.createElement("div");
            cN.innerHTML = dr;
            cX.className = cr;
            cN.className = cr;
            if (ds && cD) {
                dq = r.createElement("div");
                dq.innerHTML = ds;
                cf = dq.childNodes.item(0);
                di.pulsator.previousClass = cf.className;
                cf.className = cr;
                r.body.appendChild(cf)
            }
            r.body.appendChild(cX);
            r.body.appendChild(cN);
            cj = r.getElementById(ck);
            dk = r.getElementById(b9);
            dh = r.getElementById(cH);
            c5 = r.getElementById(bU);
            dj = r.getElementById(bV);
            b0 = r.getElementById(db);
            cV = r.getElementById(dl);
            df = r.getElementById(c4);
            cI = r.getElementById(bR);
            cA = r.getElementById(c8);
            b3 = r.getElementById(cM);
            cJ();
            c7();
            bW();
            dg()
        };
        var b1 = function () {
            var dq = a4.get(cc()), dr = a4.get(cl);
            a6.roistatLeadhunterForm = ca;
            if (!dq) {
                o("LeadHunter: requesting form from server");
                ac(am() + "//" + m + "/api/site/" + E + "/" + ai() + "/leadhunter-form?domain=" + encodeURIComponent(r.domain))
            } else {
                a6.roistatLeadhunterForm(a8.decode(dq), a8.decode(dr))
            }
        };
        var cw = function () {
            var dr = cN.clientWidth, dq = cN.clientHeight;
            cN.setAttribute("style", cN.getAttribute("style") + " width: " + dr + "px; height: " + dq + "px;");
            if (dk !== null) {
                dk.className = cr
            }
            if (cj !== null) {
                cj.className = cr
            }
            if (b0 !== null) {
                b0.className = cr
            }
            if (dh !== null) {
                dh.setAttribute("style", "width: " + dr + "px; height: " + dq + "px; display: table-cell;");
                dh.className = b7
            }
            setTimeout(function () {
                o("LeadHunter: close form after timeout");
                cK()
            }, 7000)
        };
        var cW = function () {
            var dr = Math.round((c3() - cN.clientHeight) / 2);
            var dq = Math.round((dn() - cN.clientWidth) / 2);
            cN.setAttribute("style", "left: " + dq + "px; top: " + Math.max(0, dr) + "px;")
        };
        var bX = function (dq) {
            if (a6.roistat.leadHunter.onBeforeAppear) {
                o("LeadHunter: process user defined onBeforeAppear");
                a6.roistat.leadHunter.onBeforeAppear(dq);
                cJ()
            }
            cN.setAttribute("style", "left:20px;top:-20px;opacity:0");
            cX.className = cY;
            cN.className = cG;
            dk.className = da;
            cj.className = dc;
            if (b0 !== null) {
                b0.className = cB
            }
            if (dh !== null) {
                dh.setAttribute("style", "");
                dh.className = cr
            }
            cX.setAttribute("style", "opacity:0;");
            b8 = true;
            setTimeout(function () {
                cX.setAttribute("style", "opacity:.5;")
            }, 10);
            var dr = g(a0);
            bg(cq, {visit_id: dr}, "GET");
            if (a6.roistat.leadHunter.onAfterAppear) {
                o("LeadHunter: process user defined onAfterAppear");
                a6.roistat.leadHunter.onAfterAppear(dr, cX, cN, dk)
            }
        };
        var cZ = function cL() {
            b6();
            ch = a9();
            var dq = false;
            var dr = a6.onload;
            a6.onload = function () {
                if (dr) {
                    dr()
                }
                if (!dq) {
                    dq = true;
                    o("LeadHunter: form initialized in window.onload");
                    b1()
                }
            };
            setTimeout(function () {
                if (!dq) {
                    dq = true;
                    o("LeadHunter: form initialized after timeout");
                    b1()
                }
            }, 5000)
        };
        var dg = function cy() {
            o("LeadHunter: tuning appearance for page");
            if (!dp()) {
                o("LeadHunter: disabled on page");
                di.leave.isShowEnabled = false;
                clearTimeout(di.timeoutId);
                if (cf) {
                    cf.className = cr
                }
            } else {
                o("LeadHunter: enabled on page");
                di.leave.isShowEnabled = true;
                cx();
                if (cf) {
                    cf.className = di.pulsator.previousClass
                }
            }
        };
        var cm = function cT() {
            o("LeadHunter: processing single page application state change");
            ch = a9();
            dg()
        };
        var c2 = function cE() {
            var dt = function (dv, dx, dw) {
                var du = dv[dx];
                dv[dx] = function () {
                    if (du) {
                        du.apply(this, arguments)
                    }
                    dw.apply(this, arguments)
                }
            };
            var ds = function (dw, dv, dx) {
                if (dw.addEventListener) {
                    dw.addEventListener(dv, dx, false);
                    return
                }
                var du = "on" + dv;
                if (dw.attachEvent) {
                    dw.attachEvent(du, dx);
                    return
                }
                if (du in dw) {
                    dt(dw, du, dx);
                    return
                }
                if (dv in dw) {
                    dt(dw, dv, dx);
                    return
                }
                o("Handler could not be attached")
            };
            ds(a6, "popstate", function dr() {
                o("LeadHunter: popstate event catch");
                cm()
            });
            ds(a6.history, "pushState", function dq() {
                o("LeadHunter: pushState event catch");
                cm()
            });
            ds(a6.history, "replaceState", function dq() {
                o("LeadHunter: replaceState event catch");
                cm()
            })
        };

        function cP() {
            if (!c0()) {
                return
            }
            if (!cs()) {
                return
            }
            o("LeadHunter: activated");
            cZ();
            c2()
        }

        function c3() {
            return (a6.innerHeight ? a6.innerHeight : r.documentElement.clientHeight == 0 ? r.body.clientHeight : r.documentElement.clientHeight)
        }

        function dn() {
            return (a6.innerWidth ? a6.innerWidth : r.documentElement.clientWidth == 0 ? r.body.clientWidth : r.documentElement.clientWidth)
        }

        function cU(ds) {
            ds = ds || event;
            ci = ds.clientY;
            var dq = ci / c3(), du = cb > 0 && cb > dq, dr = dq < ce, dt = (a9() - ch) > de * 1000;
            if (du && dr && !b8 && dt && di.leave.isShowEnabled) {
                o("LeadHunter: show modal with because move up (" + cb + " -> " + dq + ") and in modal zone and show on leave enabled");
                bX("exit");
                cF(ds)
            }
            if (dq < b4) {
                cb = dq
            }
        }

        function c9(dq) {
            if (bY) {
                cW()
            } else {
                dq = dq || event;
                cF(dq)
            }
        }

        function cF(ds) {
            var dq = ds.clientX - Math.round(cN.clientWidth / 2) || cN.offsetLeft;
            dq = Math.max(20, Math.min(dq, dn() - cN.offsetWidth - 20));
            var dr = dn() - 40 > cN.offsetWidth ? "" : "width:" + (cN.offsetWidth - 40) + "px;";
            cN.setAttribute("style", "left:" + dq + "px; top: 0px; " + dr)
        }

        function bZ() {
            a6.roistatSetCookie(b5, 1, br)
        }

        function cK() {
            bZ();
            cX.setAttribute("style", "opacity:0");
            cN.style.top = "-" + cN.offsetHeight * 2 + "px";
            setTimeout(function () {
                cN.className = cX.className = cr
            }, 500)
        }

        function cu() {
            var dE = r.getElementById("roistat-lh-phone-input"), ds = r.getElementById("roistat-lh-name-input"), du, dC;
            du = dE === null ? "" : dE.value;
            dC = ds === null ? "" : ds.value;
            var dz = {name: dC, phone: du, isNeedCallback: null, callbackPhone: null, fields: {}};
            if (a6.roistat.leadHunter.onBeforeSubmit) {
                o("LeadHunter: process user defined onBeforeSubmit");
                var dv = a6.roistat.leadHunter.onBeforeSubmit(dz);
                if (dv) {
                    dz = dv
                }
            }
            var dB = dz.phone.length < 1;
            var dD = dz.phone.slice(-1) !== "_";
            var dx = !dB && dD;
            var dA = dz.name.length < 1;
            var dr = !dA || !a6.roistat.leadHunter.form.isNameRequired;
            if (!dx) {
                dE.setAttribute("style", "border: 2px solid #E0571A;");
                return
            }
            if (!dr) {
                ds.setAttribute("style", "border: 2px solid #E0571A;");
                return
            }
            var dq = bT + "?v=" + y + "&lead-hunt-input=" + encodeURIComponent(dz.phone) + "&lead-name=" + encodeURIComponent(dz.name) + "&visit=" + g(a0);
            if (dz.isNeedCallback !== null && dz.isNeedCallback !== aI) {
                dq = dq + "&is_need_callback=" + (dz.isNeedCallback > 0 ? 1 : 0)
            }
            if (dz.callbackPhone) {
                dq = dq + "&callback_phone=" + dz.callbackPhone
            }
            if (a6.roistat.leadHunter.additionalNotifyEmail !== null) {
                dq = dq + "&additional_email=" + encodeURIComponent(a6.roistat.leadHunter.additionalNotifyEmail)
            }
            var dt = 0;
            if (dz.fields && typeof dz.fields === "object") {
                for (var dw in dz.fields) {
                    if (dz.fields.hasOwnProperty(dw)) {
                        ++dt
                    }
                }
            }
            if (dt > 0) {
                dq = dq + "&fields=" + dd(JSON.stringify(dz.fields))
            }
            dq = dq + "&t=" + a9();
            var dy = r.createElement("img");
            dy.src = dq;
            dE.setAttribute("style", "");
            bZ();
            if (dh === null) {
                cK();
                cp()
            } else {
                cw()
            }
            if (a6.roistat.leadHunter.onAfterSubmit) {
                o("LeadHunter: process user defined onAfterSubmit");
                a6.roistat.leadHunter.onAfterSubmit({name: dC, phone: du})
            }
        }

        function cC(dq) {
            if (dq.preventDefault) {
                dq.preventDefault()
            } else {
                dq.returnValue = false
            }
            cI.style.display === "block" ? cI.style.display = "none" : cI.setAttribute("style", "display: block; width:" + (cN.clientWidth - 20) + "px;");
            b3.style.position === "static" ? b3.style.position = "absolute" : b3.style.position = "static";
            c9()
        }

        function dm() {
            dj.disabled === true ? dj.disabled = false : dj.disabled = true;
            cA.style.display === "block" ? cA.style.display = "none" : cA.style.display = "block"
        }

        function cp() {
            r.onmousemove = null;
            cX.onresize = null
        }

        var cn = function (dw, dz) {
            if (!dw || !dz) {
                o("LeadHunter: skip phone mask render due to empty input or mask");
                return
            }
            o("LeadHunter: render phone mask " + dz + " for input: " + dw.value);
            if (a6.roistatRenderPhoneMaskMutex) {
                return
            }
            a6.roistatRenderPhoneMaskMutex = true;
            var dt = "_", ds = "x", dv = "х", du = dz.toLowerCase().split(ds).join(dt).split(dv).join(dt);
            var dr = function (dA) {
                if (dw.setSelectionRange) {
                    dw.setSelectionRange(dA, dA)
                } else {
                    if (dw.createTextRange) {
                        var dB = dw.createTextRange();
                        dB.collapse(true);
                        dB.moveEnd("character", dA);
                        dB.moveStart("character", dA);
                        dB.select()
                    }
                }
            };
            var dx = function (dA) {
                if (!dA) {
                    return 0
                }
                var dB = dA.indexOf(dt);
                if (dB < 0) {
                    return dA.length
                }
                return dB
            };
            var dy = function (dA) {
                dr(dx(dA))
            };
            var dq = function (dJ) {
                var dK = du.split("");
                if (!dJ) {
                    return du
                }
                var dA = dJ.split("");
                var dL = [], dI, dF, dH, dE, dC, dB, dG;
                for (var dD = 0; dD < dK.length; dD++) {
                    dF = dK[dD];
                    if (dD >= dA.length) {
                        dL.push(dF);
                        continue
                    }
                    dC = ((dD + 1) < dK.length) ? dK[dD + 1] : null;
                    dB = ((dD + 1) < dA.length) ? dA[dD + 1] : null;
                    dG = ((dD + 2) < dA.length) ? dA[dD + 2] : null;
                    dI = dA[dD];
                    dH = parseInt(dI) >= 0;
                    dE = (dF === dt) && dH;
                    if (!dE) {
                        dL.push(dF);
                        continue
                    }
                    if (dB === dt && dC !== dt && dG !== dC) {
                        dL.push(dF);
                        continue
                    }
                    dL.push(dI)
                }
                return dL.join("")
            };
            setTimeout(function () {
                var dA = dq(dw.value);
                if (dw.value !== dA) {
                    dw.value = dA
                }
                dy(dA);
                a6.roistatRenderPhoneMaskMutex = false
            }, 1)
        };
        var c1 = function (dq, dr) {
            a4.set(cc(), a8.encode(dq));
            a4.set(cl, a8.encode(dr))
        };
        bi(cP);
        a6.roistatLeadHunterShow = cz;
        a6.roistatRenderPhoneMask = cn;
        a6.roistatSaveLeadHunterTemplates = c1
    })();
    (function l() {
        var b4 = function () {
            return g(bN)
        };
        var b2 = function () {
            return a4.get(au)
        };
        var bV = function () {
            return a4.get(aD)
        };
        var b8 = function (ca) {
            return ca != null && ca !== aI && ca !== ""
        };
        var b7 = function (ca) {
            try {
                var cb = JSON.parse(ca);
                if (cb && typeof cb === "object") {
                    return cb
                }
            } catch (cc) {
            }
            return null
        };
        var b6 = function () {
            var ca = [];
            var cb = r.getElementsByClassName(L);
            if (cb && cb.length) {
                ca = cb
            }
            return ca
        };
        var bT = function () {
            var ca = [];
            var cb = r.getElementsByClassName(q);
            if (cb && cb.length) {
                ca = cb
            }
            return ca
        };
        var bS = function () {
            var ca = [];
            var cb = r.getElementsByClassName(G);
            if (cb && cb.length) {
                ca = cb
            }
            return ca
        };
        var bX = function () {
            var ca = [];
            var cb = r.getElementsByClassName(t);
            if (cb && cb.length) {
                ca = cb
            }
            return ca
        };
        var b0 = function () {
            var ca = [];
            var cb = r.getElementsByClassName(bH);
            if (cb && cb.length) {
                ca = cb
            }
            return ca
        };
        var bR = function (cl, ca) {
            o("RenderPhone phone = " + cl);
            var cf = function (cn) {
                return cn.split(/[^0-9]/).join("")
            };
            var ch = function (cq, cs) {
                var cv = null;
                if (!cq) {
                    return cv
                }
                var cn = cs.split(",");
                if (cn.length < 2) {
                    cv = cs
                } else {
                    var co = cq.getAttribute("data-prefix");
                    if (co) {
                        for (var cr = 0; cr < cn.length; cr++) {
                            var ct = cn[cr];
                            var cu = cf(ct);
                            if (cu.indexOf("8") === 0) {
                                cu = "7" + cu.substring(1)
                            }
                            var cp = cu.split(co)[0] === "";
                            if (cp) {
                                cv = ct;
                                break
                            }
                        }
                    }
                    if (cv === null) {
                        cv = cn[0]
                    }
                    o("CallTracking._getPhoneForElement: Prepared phone = " + cv + " for data-prefix = " + co)
                }
                return cv
            };
            var cd = function (cr, cp) {
                var cn = ch(cr, cp);
                if (!cn || !cr) {
                    return
                }
                if (cr.tagName.toLowerCase() !== "a") {
                    return
                }
                var cq = cr.getAttribute("href");
                if (bC(cq, "tel:")) {
                    var co = cf(cn);
                    if (co.indexOf("8") === 0) {
                        co = "7" + co.substring(1)
                    }
                    cr.setAttribute("href", "tel:+" + co)
                }
            };
            var cj = function (cp, co) {
                var cn = ch(cp, co);
                if (!cn || !cp) {
                    return
                }
                cp.innerHTML = cn
            };
            var cm = function (cn) {
                var co = b6();
                o("CallTracking: render phone default classes for " + co.length + " elements");
                k(co, function (cp) {
                    cj(cp, cn);
                    cd(cp, cn)
                });
                k(bT(), function (cq) {
                    var cp = cf(ch(cq, cn)).slice(0, 1);
                    cj(cq, cp)
                });
                k(bS(), function (cq) {
                    var cr = ch(cq, cn).match(/\((.*)\)/);
                    if (cr !== null) {
                        var cp = cr[1];
                        cj(cq, cp)
                    }
                });
                k(bX(), function (cr) {
                    var cp = ch(cr, cn).match(/\)(.*)/);
                    if (cp !== null) {
                        var cs = cf(cp[1]);
                        var cq = cs.slice(-1 * cs.length, -4) + "-" + cs.slice(-4, -2) + "-" + cs.slice(-2);
                        cj(cr, cq)
                    }
                });
                k(b0(), function (cp) {
                    cd(cp, cn)
                })
            };
            var ck = function (cn, cs) {
                if (!cs) {
                    return
                }
                o("CallTracking: render phone user replacement for " + cs.length + " replacements");
                for (var cr = 0; cr < cs.length; cr++) {
                    var cu = cs[cr];
                    if (!cu) {
                        continue
                    }
                    var cp = cu[0];
                    cu = cu.substr(1);
                    var ct = [];
                    if (cp === "#") {
                        var cq = r.getElementById(cu);
                        if (cq !== null) {
                            ct.push(cq)
                        }
                    } else {
                        ct = r.getElementsByClassName(cu);
                        cc(cu, cn)
                    }
                    if (!ct || ct.length < 1) {
                        continue
                    }
                    o("CallTracking: render phone for " + cu + ", " + ct.length + " elements");
                    for (var co = 0; co < ct.length; co++) {
                        cj(ct[co], cn);
                        cd(ct[co], cn)
                    }
                }
            };
            var ci = function (cn) {
                for (var co = 0; co < cn.length; co++) {
                    ck(cn[co].phone, cn[co].css_selectors)
                }
            };
            var cc = function (co, cn) {
                k(cb(co + "-" + aN), function (cq) {
                    var cp = cf(ch(cq, cn)).slice(0, 1);
                    cj(cq, cp)
                });
                k(cb(co + "-" + Z), function (cq) {
                    var cr = ch(cq, cn).match(/\((.*)\)/);
                    if (cr !== null) {
                        var cp = cr[1];
                        cj(cq, cp)
                    }
                });
                k(cb(co + "-" + at), function (cr) {
                    var cp = ch(cr, cn).match(/\)(.*)/);
                    if (cp !== null) {
                        var cs = cf(cp[1]);
                        var cq = cs.slice(-1 * cs.length, -4) + "-" + cs.slice(-4, -2) + "-" + cs.slice(-2);
                        cj(cr, cq)
                    }
                });
                k(cb(co + "-" + aX), function (cp) {
                    cd(cp, cn)
                })
            };
            var cb = function (co) {
                var cn = [];
                var cp = r.getElementsByClassName(co);
                if (cp && cp.length) {
                    cn = cp
                }
                return cn
            };
            var ce = bV();
            if (ce) {
                ce = ce.split("\n");
                for (var cg = 0; cg < ce.length; cg++) {
                    ce[cg] = "." + ce[cg]
                }
            }
            if (ca instanceof Array) {
                ci(ca)
            } else {
                cm(cl);
                ck(cl, ce)
            }
        };
        var bU = function (ca) {
            a4.save(i, ca, br)
        };
        var b3 = function () {
            if (a6.roistat.callTracking.phone) {
                var ca = {expires: parseInt(a6.roistat.callTracking.sessionTime), path: "/"};
                if (br.domain) {
                    ca.domain = br.domain
                }
                bI(bN, a6.roistat.callTracking.phone, ca);
                bU(1);
                a4.save(aD, a6.roistat.callTracking.replacementClasses, br);
                a4.save(au, a6.roistat.callTracking.phoneScriptsJson, br)
            }
        };
        var b1 = function (ca, ce, cc, cb) {
            o("CallTracking: reuse phone " + ca + " for time " + ce + " and replacements " + cc);
            if (!b8(ca)) {
                o("CallTracking: new phone is invalid");
                roistat.callTracking.phone = null;
                bE();
                return
            }
            roistat.callTracking.enabled = 1;
            roistat.callTracking.phone = ca;
            roistat.callTracking.sessionTime = ce;
            roistat.callTracking.replacementClasses = cc;
            roistat.callTracking.phoneScriptsJson = cb;
            bE();
            b3();
            var cf = {expires: parseInt(ce), path: "/"};
            if (br.domain) {
                cf.domain = br.domain
            }
            bI(bN, ca, cf);
            a4.save(au, cb, br);
            a4.save(aD, cc, br);
            var cd = b7(cb);
            if (cd == null) {
                bR(ca)
            } else {
                bR(ca, cd)
            }
        };
        var bW = function () {
            o("CallTracking: request new phone");
            var ca = g(a0);
            var ce = J();
            var cd = ce ? ce : aE;
            var cc = encodeURIComponent(bh);
            var cb = w() + "/get-phone?visit=" + ca + "&marker=" + (cd ? cd : "") + "&prefix=" + bk + "&prefix_bind=" + bO + "&phone_scripts_bind=" + x + "&page=" + cc;
            ac(cb)
        };
        var bY = function () {
            bk = a6.roistatPhonePrefix ? a6.roistatPhonePrefix : "";
            bO = a6.roistatPhonePrefixBind ? a6.roistatPhonePrefixBind : "";
            x = a6.roistatCalltrackingScripts && a6.roistatCalltrackingScripts.join ? a6.roistatCalltrackingScripts.join(",") : "";
            o("CallTracking: refresh phone with prefix: " + bk + ", binding: " + bO + ", scripts: " + x);
            bW()
        };
        var b9 = function () {
            var ca = a4.get(i) > 0;
            var cb = aU.callTrackingEnabled;
            return ca && cb
        };
        var bZ = function (ca) {
            bU(ca.is_enabled)
        };
        var b5 = function () {
            o("CallTracking: init");
            b3();
            if (!b9()) {
                o("CallTracking: disabled, skip");
                return
            }
            if (aU.callTrackingManual) {
                o("CallTracking: init finish because off manual")
            } else {
                var ca = b4();
                if (!b8(ca)) {
                    o("CallTracking: invalid phone " + ca + ", requesting a new one");
                    bW()
                } else {
                    o("CallTracking: render phone " + ca);
                    var cb = b7(b2());
                    if (cb == null) {
                        bR(ca)
                    } else {
                        bR(ca, cb)
                    }
                }
            }
        };
        a6.roistatCallTrackingRefresh = bY;
        a6.roistatRequestNewPhone = bW;
        a6.roistatReusePhone = b1;
        a6.roistatCalltrackingUpdateSettings = bZ;
        bi(b5)
    })();
    (function p() {
        var bT = function (bZ) {
            o("Emailtracking: " + bZ)
        };
        var bX = function (bZ, b0) {
            a4.save(aC, bZ, br);
            a4.save(a, b0, br)
        };
        var bS = function () {
            if (a6.roistat.emailtracking.loaded && a6.roistat.emailtracking.email && a6.roistat.emailtracking.trackingEmail) {
                bT("save loaded email: " + a6.roistat.emailtracking.email);
                bX(a6.roistat.emailtracking.email, a6.roistat.emailtracking.trackingEmail)
            } else {
                bT("settings save skip, because not loaded");
                a6.roistat.emailtracking.email = a4.get(aC);
                a6.roistat.emailtracking.email = a6.roistat.emailtracking.email ? a6.roistat.emailtracking.email : null;
                a6.roistat.emailtracking.email = a6.roistat.emailtracking.email === "null" ? null : a6.roistat.emailtracking.email;
                bT("email loaded from storage: " + a6.roistat.emailtracking.email);
                a6.roistat.emailtracking.trackingEmail = a4.get(a);
                a6.roistat.emailtracking.trackingEmail = a6.roistat.emailtracking.trackingEmail ? a6.roistat.emailtracking.trackingEmail : null;
                a6.roistat.emailtracking.trackingEmail = a6.roistat.emailtracking.trackingEmail === "null" ? null : a6.roistat.emailtracking.trackingEmail;
                bT("tracking email loaded from storage: " + a6.roistat.emailtracking.trackingEmail)
            }
        };
        var bV = function (bZ) {
            bX(bZ.email, bZ.trackingEmail)
        };
        var bU = function () {
            return a6.roistat.emailtracking.enabled && !!a6.roistat.emailtracking.email && !!a6.roistat.emailtracking.trackingEmail
        };
        var bR = function () {
            if (!bU()) {
                bT("emailtracking disabled, skip swapping");
                return
            }
            var cc = function (cf, cg, ce) {
                if (cf.href) {
                    if (cg.test(cf.href)) {
                        cf.href = cf.href.replace(cg, ce);
                        return true
                    }
                }
                if (cf.nodeType !== 3) {
                    return false
                }
                if (cf.textContent && cg.test(cf.textContent)) {
                    cf.textContent = cf.textContent.replace(cg, ce);
                    return true
                } else {
                    if (cf.innerText && cg.test(cf.innerText)) {
                        cf.innerText = cf.innerText.replace(cg, ce);
                        return true
                    }
                }
                return false
            };
            var b5 = function (ce) {
                return ce.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")
            };
            var b8 = a6.roistat.emailtracking.email;
            var cb = b5(b8);
            var b1 = new RegExp("(^|\\s)(mailto:)?(" + cb + ")($|\\s)", "g");
            var ca = a6.roistat.emailtracking.trackingEmail;
            var cd = function (ci, cg, ce, cf, ch) {
                ce = ce || "";
                return cg + ce + ca + ch
            };
            bT("starting to replace email " + b8 + " to " + ca + " with regexp " + b1);
            var b0 = r.getElementsByTagName("*");
            var b3 = b0.length;
            bT("found " + b3 + " nodes on page");
            var b7 = 0;
            for (var b6 = 0; b6 < b3; b6++) {
                var b2 = b0[b6];
                var b9 = b2.childNodes.length;
                if (b9 > 0) {
                    for (var b4 = 0; b4 < b9; b4++) {
                        var bZ = b2.childNodes[b4];
                        if (cc(bZ, b1, cd)) {
                            b7++
                        }
                    }
                }
                if (cc(b2, b1, cd)) {
                    b7++
                }
            }
            bT("successfully replaced " + b7 + " nodes")
        };
        var bW = function () {
            bT("process email swap");
            bR();
            setTimeout(function () {
                bR()
            }, 300);
            setTimeout(function () {
                bR()
            }, 5000);
            setTimeout(function () {
                bR()
            }, 15000)
        };
        var bY = function () {
            bT("init");
            bS();
            bW()
        };
        a6.roistatEmailtrackingUpdateSettings = bV;
        a6.roistat.emailtracking.refresh = bR;
        bi(bY)
    })();
    (function ay() {
        var bU = function (bW) {
            o("MultiDomain: " + bW)
        };
        var bT = function () {
            return a4.get(bs) > 0
        };
        var bS = function (b0) {
            var b1 = function (b2) {
                if (!b2) {
                    return false
                }
                if (bC(b2, "roistat_visit")) {
                    return false
                }
                var b3 = new RegExp("^(https?:)?//\\w+\\.\\w+");
                return b3.test(b2)
            };
            var bZ = function (b5) {
                var b6 = b5.split("#");
                var b4 = b6[0].split("?");
                var b2 = "";
                var b3 = "";
                if (b4.length === 2) {
                    b2 = b4[1]
                }
                if (b2) {
                    b3 = "&"
                }
                b2 = b2 + b3 + "roistat_visit=" + roistat.getVisit();
                b4[1] = b2;
                b6[0] = b4.join("?");
                return b6.join("#")
            };
            if (b0.tagName.toLowerCase() !== "a") {
                return
            }
            var bY = b0.getAttribute("href");
            var bX = false;
            if (b1(bY)) {
                var bW = bZ(bY);
                bU("update url " + bY + " > " + bW);
                b0.setAttribute("href", bW);
                bX = true
            }
            return bX
        };
        var bR = function () {
            if (!bT()) {
                bU("disabled, skip");
                return
            }
            var bW = r.getElementsByTagName("a");
            var bX = bW.length;
            bU("found " + bX + " <a> nodes on page");
            var b0 = 0;
            for (var bY = 0; bY < bX; bY++) {
                var bZ = bW[bY];
                if (bS(bZ)) {
                    b0++
                }
            }
            bU("replaced " + b0 + " nodes")
        };
        var bV = function () {
            bU("init");
            bR();
            setTimeout(function () {
                bR()
            }, 300);
            setTimeout(function () {
                bR()
            }, 5000);
            setTimeout(function () {
                bR()
            }, 15000)
        };
        bi(bV)
    })();
    (function bz() {
        var bS = 5 * 60 * 1000;
        var bR = "roistat_last_settings_update_time";
        var bT = function (b1) {
            o("SettingsUpdater: " + b1)
        };
        var bW = function () {
            return a4.get(bR)
        };
        var bY = function () {
            a4.set(bR, a9())
        };
        var bZ = function () {
            var b2 = bW();
            var b1 = !(b2 > 0);
            bT("is first update check: lastUpdateTime=" + b2 + ", result=" + (b1 ? 1 : 0));
            return b1
        };
        var b0 = function () {
            var b3 = a9() - bS;
            var b2 = bW();
            var b1 = b2 < b3;
            bT("expiration check: _minTime=" + b3 + ", lastUpdateTime=" + b2 + ", result=" + (b1 ? 1 : 0));
            return b1
        };
        var bV = function () {
            var b1 = g(a0);
            var b2 = w() + "/get-settings?visit=" + b1;
            bT("request new settings");
            ac(b2)
        };
        var bU = function (b1) {
            bT("update settings and save last update time");
            a6.roistatCalltrackingUpdateSettings(b1.calltracking);
            a6.roistatEmailtrackingUpdateSettings(b1.emailtracking);
            a6.roistatSaveLeadHunterTemplates(b1.leadhunter_templates.form_template, b1.leadhunter_templates.pulsator_template);
            a6.roistatSaveProxyFormSettings(b1.proxy_forms);
            an(b1.js_settings);
            bY()
        };
        var bX = function () {
            bT("init");
            if (bZ()) {
                bT("in first update we just start first timer and skip");
                bY();
                return
            }
            if (!b0()) {
                bT("update is not not expired, skip");
                return
            }
            bT("start to update settings");
            bV()
        };
        bi(function () {
            setTimeout(function () {
                bX()
            }, 3000)
        });
        a6.roistatUpdateSettings = bU
    })();
    (function aS(bV, bR, bX) {
        var bU = {};
        var bS = function (bZ) {
            var bY = encodeURIComponent ? encodeURIComponent : encodeURI;
            return bY(bZ)
        };
        var bT = function (b5, bZ) {
            o("Reach goal start");
            if (!b5) {
                b5 = {}
            }
            var b2 = {
                leadName: "",
                formTitle: "",
                name: "",
                phone: "",
                email: "",
                price: "",
                text: "",
                fields: "",
                client_fields: "",
                is_need_callback: "",
                callback_phone: "",
                visit: j()
            };
            for (var b1 in b2) {
                if (!Object.prototype.hasOwnProperty.call(b2, b1)) {
                    continue
                }
                if (!Object.prototype.hasOwnProperty.call(b5, b1)) {
                    continue
                }
                if (!b5[b1]) {
                    continue
                }
                if (b1 === "fields" || b1 === "client_fields") {
                    b5[b1] = JSON.stringify(b5[b1])
                }
                b2[b1] = bS(b5[b1])
            }
            var b4 = ai();
            var b3 = am() + "//" + m + "/api/site/" + E + "/" + b4 + "/reach-goal?v=2";
            for (var b0 in b2) {
                if (!Object.prototype.hasOwnProperty.call(b2, b0)) {
                    continue
                }
                b3 = b3 + "&" + b0 + "=" + b2[b0]
            }
            if (bZ !== bX) {
                var bY = Math.random().toString();
                bU[bY] = bZ;
                b3 += "&callback_key=" + bY
            }
            ac(b3);
            o("Reach goal completed")
        };
        var bW = bV.roistatGoal = {
            reach: function (bZ, bY) {
                bT(bZ, bY)
            }, callAfterReachCallback: function (bY) {
                if (Object.prototype.hasOwnProperty.call(bU, bY)) {
                    bU[bY]();
                    delete bU[bY]
                }
            }
        }
    })(a6, r, aI);
    (function bK(bT, bR, bU) {
        var bS = function (bZ) {
            if (bZ instanceof Array || bZ === null || typeof bZ !== "object") {
                o("Invalid event data");
                return ""
            }
            var bW = [];
            for (var bY in bZ) {
                if (Object.prototype.hasOwnProperty.call(bZ, bY)) {
                    var bX = bZ[bY];
                    if (typeof bX === "string" || typeof bX === "number") {
                        bW.push("data[" + encodeURIComponent(bY) + "]=" + encodeURIComponent(bX))
                    } else {
                        o("Event data property ignored: " + bY)
                    }
                }
            }
            return bW.length > 0 ? "&" + bW.join("&") : ""
        };
        var bV = function (bY, bZ) {
            o("Send event start");
            var bW = j();
            var bX = w() + "/event/register?visit=" + bW + "&event=" + bY + bS(bZ);
            ac(bX);
            o("Send event completed")
        };
        bT.roistat.event = {
            send: function (bW, bX) {
                bV(bW, bX)
            }
        }
    })(a6, r, aI);
    (function a5(b1, b3, bU) {
        var b4 = b1.roistatIsInitVisit === true ? 20000 : 10000;
        var bT = (new Date()).getTime();
        var bS = function (b8) {
            return "approve_visit_" + b8
        };
        var b0 = function (b8) {
            aY.set(bS(b8), 1)
        };
        var b5 = function (b8) {
            return aY.get(bS(b8)) > 0
        };
        var bR, bW, b7 = [];
        if (b3.addEventListener) {
            bR = function (b9, b8, ca) {
                return b9.addEventListener(b8, ca, false)
            };
            bW = function (b9, b8, ca) {
                return b9.removeEventListener(b8, ca, false)
            }
        } else {
            bR = function (b9, b8, ca) {
                return b9.attachEvent("on" + b8, ca)
            };
            bW = function (b9, b8, ca) {
                return b9.detachEvent("on" + b8, ca)
            }
        }
        var bZ = function (cb) {
            if (b7.length > 30) {
                return
            }
            cb = cb || b1.event;
            if (!cb || !cb.screenX) {
                return
            }
            var ca = (new Date()).getTime();
            var cd, cc = null;
            if (b7.length > 0) {
                cc = b7[b7.length - 1]
            }
            if (cc) {
                cd = ca - cc.time
            } else {
                cd = ca - bT
            }
            if (cd < 300) {
                return
            }
            cd = cd - 300;
            var cf = 0;
            var b8 = cb.screenX;
            var ce = cb.screenY;
            if (cc) {
                cf = parseInt(Math.sqrt(Math.pow(cc.y - ce, 2) + Math.pow(cc.x - b8, 2)))
            }
            var b9 = {time: ca, pauseBeforeMove: cd, x: b8, y: ce, distance: cf};
            b7.push(b9)
        };
        var bY = function () {
            var b8 = [];
            k(b7, function (b9) {
                var ca = [b9.pauseBeforeMove, b9.distance];
                b8.push(ca.join(":"))
            });
            if (b8.length === 0) {
                b8.push("0:0")
            }
            return b8.join("|")
        };
        var bV = function () {
            for (var b8 in b1) {
                if (bC(b8, "yaCounter")) {
                    return true
                }
            }
            return false
        };
        var b2 = function () {
            bW(b3, "mousemove", bZ);
            var b8 = j();
            o("VisitApprove: start for visit " + b8);
            if (b5(b8)) {
                o("VisitApprove: visit already approved, skip");
                return
            }
            b0(b8);
            var b9 = w() + "/approve?v=" + y + "&visit=" + b8;
            if (b6()) {
                b9 += "&hash=" + N()
            }
            if (bX()) {
                b9 += "&page_params=" + encodeURIComponent(JSON.stringify(b1.roistat.page.params));
                d()
            }
            b9 += "&mv=" + bY();
            b9 += "&pl=" + (b1.navigator ? b1.navigator.platform : "");
            b9 += "&ym=" + (bV() ? "1" : "0");
            ac(b9)
        };
        var b6 = function () {
            var cc = a2.cookies, cb = h();
            for (var b9 = 0; b9 < aQ.length; b9++) {
                var cd = aQ[b9];
                var ce = Object.prototype.hasOwnProperty.call(cc, cd) ? cc[cd] : bU;
                var b8 = Object.prototype.hasOwnProperty.call(cb, cd) ? cb[cd] : bU;
                var ca = typeof b8 === "string" && b8.length > 0;
                if (ca && ce !== b8) {
                    return true
                }
            }
            return false
        };
        var bX = function () {
            var cd = a2.pageParams, ca = b1.roistat.page.params;
            for (var b9 = 0; b9 < bl.length; b9++) {
                var b8 = bl[b9];
                var cb = Object.prototype.hasOwnProperty.call(cd, b8) ? cd[b8] : null;
                var cc = Object.prototype.hasOwnProperty.call(ca, b8) ? ca[b8] : null;
                if (cc !== cb) {
                    return true
                }
            }
            return false
        };
        setTimeout(function () {
            b2()
        }, b4);
        bR(b3, "mousemove", bZ)
    })(a6, r, aI);
    (function R(bW, bX, bS) {
        var bU = function () {
            return A("roistat_ab_demo") === "1"
        };
        var bY = function (b1) {
            return new RegExp(b1.split(".").join("\\.").split("*").join(".*").split("?").join("."))
        };
        var bV = function (b6) {
            var b1 = bW.location.href, b4 = b6.filter, ca = b6.filterValue;
            var b7;
            switch (b4) {
                case"except":
                case"pages":
                    var b2, b9, b8 = false;
                    b9 = b1 ? Y(b1) : "";
                    b7 = ca ? ca.split("\n") : [];
                    if (b9 && b7.length !== 0) {
                        for (var b3 = 0; b3 < b7.length; b3++) {
                            var b5 = b7[b3].trim();
                            if (b5.length === 0) {
                                continue
                            }
                            b2 = bY(b5);
                            if (b2.test(b9)) {
                                b8 = true;
                                break
                            }
                        }
                    }
                    return (b4 === "pages") ? b8 : !b8;
                    break;
                case"all":
                default:
                    return true
            }
        };
        var bR = function (b3) {
            var b1 = bX.getElementsByTagName("head")[0], b2;
            b2 = bX.createElement("style");
            b2.setAttribute("type", "text/css");
            if (b2.styleSheet) {
                b2.styleSheet.cssText = b3.value
            } else {
                b2.innerText = b3.value
            }
            b1.appendChild(b2)
        };
        var bT = function (b1) {
            if (bV(b1)) {
                switch (b1.type) {
                    case"css":
                        bR(b1);
                        break
                }
            }
        };
        bW.applyTests = function () {
            var b1 = a4.getObject("abTesting");
            var b3, b2;
            for (b3 in b1) {
                if (!Object.prototype.hasOwnProperty.call(b1, b3)) {
                    continue
                }
                b2 = b1[b3];
                bT(b2)
            }
        };
        var bZ = function () {
            o("Call: apply demo AB test");
            var b1 = A("roistat_ab_data");
            var b2;
            if (b1 === null) {
                return
            } else {
                b2 = JSON.parse(a8.decode(b1))
            }
            if (typeof b2 !== "object") {
                o("Error: testValue is not an object.");
                return
            }
            bT(b2)
        };

        function b0() {
            var b1 = bU();
            if (!bw && !b1) {
                applyTests()
            }
            if (b1) {
                bZ()
            }
        }

        b0()
    })(a6, r, aI);
    (function ao(bS, bR, bT) {
        if (!by) {
            return
        }
        setTimeout(function () {
            (function (b0, bZ, b3, b2, bX, bV, bY) {
                b0[bX] = {COUNTER_ID: bV, HOST: bY};
                var bW = bZ.location.protocol == "https:" ? "https://" : "http://";
                var bU = bZ.createElement(b3);
                bU.async = 1;
                bU.src = bW + bY + b2;
                var b1 = bZ.getElementsByTagName(b3)[0];
                b1.parentNode.insertBefore(bU, b1)
            })(bS, bR, "script", "/counter.js", "datamap", ai(), by)
        }, 1000)
    })(a6, r, aI);
    (function a3(bT, bR, bU) {
        var bV = function () {
            var bW = bT.roistatMetrikaCounterId;
            if (bW) {
                a4.set(ae, bW)
            }
        };
        var bS = function (b1) {
            var bW = "yaCounter" + b1;
            var b0 = 100, bY = 0, bZ = 60000;
            var bX = function () {
                bY += b0;
                o("YandexMetrika: trying to access counter " + b1);
                if (bT[bW] === bU) {
                    if (bY < bZ) {
                        setTimeout(bX, b0);
                        b0 *= 2
                    }
                    return
                }
                var b2 = {};
                b2[bo] = j();
                bT[bW].params(b2);
                o("YandexMetrika: visit id " + b2[bo] + " sent to counter " + b1)
            };
            setTimeout(bX, b0)
        };
        bi(function () {
            bV();
            var bY = a4.get(ae);
            if (!bY) {
                o("YandexMetrika: counter id not found");
                return
            }
            var bX = String(bY).split(",");
            o("YandexMetrika: counters: " + bX);
            for (var bW = 0; bW < bX.length; bW++) {
                if (bX[bW].trim() === "") {
                    continue
                }
                bS(bX[bW])
            }
        })
    })(a6, r, aI);
    (function O(bZ, b3) {
        var b7 = function (b9) {
            o("Proxy Forms: " + b9)
        };
        var bW = function () {
            if (bZ.roistat.proxyForms.loaded && bZ.roistat.proxyForms.settings.length > 0) {
                b7("save loaded settings");
                b4(bZ.roistat.proxyForms.settings)
            } else {
                b7("settings not loaded, getting from storage");
                bZ.roistat.proxyForms.settings = a4.getObject(bJ) || []
            }
        };
        var b4 = function (b9) {
            a4.setObject(bJ, b9)
        };
        var b0 = function () {
            b7("init form listener");
            bT(bZ.roistat.proxyForms.settings);
            bR(bZ.roistat.proxyForms.settings)
        };
        var bR = function (b9) {
            var cb = [];
            k(b9, function (cc) {
                if (cc.type === "js-button") {
                    cb.push(cc)
                }
            });
            if (cb.length < 1) {
                b7("no button settings");
                return
            }
            var ca;
            if (b3.addEventListener) {
                ca = function (cc) {
                    bV(cb, cc, cc.target, bU)
                };
                b3.addEventListener("click", ca, true)
            } else {
                if (b3.attachEvent) {
                    ca = function () {
                        var cc = bZ.event;
                        bV(cb, cc, cc.srcElement, bU, true)
                    };
                    b3.attachEvent("onclick", ca)
                } else {
                    b7("Listener could not be attached")
                }
            }
        };
        var bT = function (ca) {
            var b9 = [];
            k(ca, function (cc) {
                if (cc.type === "form") {
                    b9.push(cc)
                }
            });
            if (b9.length < 1) {
                b7("no form settings");
                return
            }
            if (b3.addEventListener) {
                var cb = function (cc) {
                    bV(b9, cc, cc.target, b8)
                };
                b3.addEventListener("submit", cb, true)
            } else {
                if (b3.attachEvent) {
                    setInterval(function () {
                        var cc = b3.getElementsByTagName("form");
                        k(cc, function (cd) {
                            if (cd.getAttribute("data-roistat-proxy-form-checked") === "true") {
                                return
                            }
                            cd.setAttribute("data-roistat-proxy-form-checked", "true");
                            k(b9, function (ce) {
                                if (bS(cd, ce.selector)) {
                                    cd.attachEvent("onsubmit", function () {
                                        bZ.event.returnValue = false;
                                        b8(ce, bZ.event.srcElement)
                                    })
                                }
                            })
                        })
                    }, 2000)
                } else {
                    b7("Listener could not be attached")
                }
            }
        };
        var bV = function (cc, cd, ce, cb, b9) {
            var ca = null;
            k(cc, function (cf) {
                if (bS(ce, cf.selector)) {
                    ca = cf
                }
            });
            if (ca === null) {
                b7("No matched settings found for listener");
                return
            }
            cb(cd, ca, ce, b9)
        };
        var b8 = function (cd, cb, cc, ca) {
            var b9 = b2(cc, cb);
            if (!b5(b9, cb)) {
                return
            }
            ca ? cd.returnValue = false : cd.preventDefault();
            bX(b9, cb, function () {
                HTMLFormElement.prototype.submit.call(cc)
            })
        };
        var bU = function (cb, ca) {
            var b9 = b2(null, ca);
            if (!b5(b9, ca)) {
                return
            }
            bX(b9, ca)
        };
        var bX = function (b9, cb, cd) {
            var cc = {};
            var ca = cb.type === "form" ? "формы" : "кнопки";
            cc.leadName = "Новый лид с " + ca + " " + cb.title;
            cc.formTitle = cb.title;
            cc.name = b9.name;
            cc.phone = b9.phone;
            cc.email = b9.email;
            cc.text = b9.comment;
            cc.fields = b9.fields;
            cc.is_need_callback = cb.is_need_callback;
            bZ.roistatGoal.reach(cc, cd)
        };
        var bY = function (b9) {
            return (typeof b9 === "number" && !isNaN(b9)) || (typeof b9 === "string" && b9 !== "") || (typeof b9 === "object" && b9 !== null) || (typeof b9 === "boolean" && b9) || aB(b9)
        };
        var b5 = function (b9, cb) {
            var ca = [], cd = ["name", "email", "phone", "comment"];
            k(cd, function (ce) {
                if (cb.hasOwnProperty(ce) && cb[ce].required > 0) {
                    ca.push(ce)
                }
            });
            if (aB(cb.fields)) {
                k(cb.fields, function (ce) {
                    if (ce.required > 0) {
                        ca.push(ce)
                    }
                })
            }
            var cc = true;
            k(ca, function (ce) {
                if (!b9.hasOwnProperty(ce) || !bY(b9[ce])) {
                    cc = false
                }
            });
            return cc
        };
        var b2 = function (cb, ca) {
            var b9 = {};
            b9.name = ca.name ? b1(cb, ca.name.value, ca.name.type) : "";
            b9.phone = ca.phone ? b1(cb, ca.phone.value, ca.phone.type) : "";
            b9.email = ca.email ? b1(cb, ca.email.value, ca.email.type) : "";
            b9.comment = ca.comment ? b1(cb, ca.comment.value, ca.comment.type) : "";
            b9.fields = {};
            if (aB(ca.fields)) {
                k(ca.fields, function (cc) {
                    b9.fields[cc.name] = b1(cb, cc.value, cc.type)
                })
            }
            return b9
        };
        var b1 = function (ca, cd, b9) {
            switch (b9) {
                case"plain":
                    return cd || "";
                case"input":
                    var cc = ca.querySelector('input[name="' + cd + '"]');
                    return cc ? cc.value : "";
                case"js":
                    try {
                        return (new Function(cd))()
                    } catch (cb) {
                        return ""
                    }
            }
        };
        var b6 = function () {
            b7("init");
            if (!bZ.roistat.proxyForms.enabled) {
                b7("disabled");
                return
            }
            bW();
            b0()
        };
        var bS = function (cb, b9) {
            if (typeof Element !== "undefined" && Element.prototype.matches) {
                return cb.matches(b9)
            } else {
                if (typeof Element !== "undefined" && Element.prototype.matchesSelector) {
                    return cb.matchesSelector(b9)
                } else {
                    if (b3.querySelectorAll) {
                        var cc = b3.querySelectorAll(b9);
                        for (var ca = 0; ca < cc.length; ca++) {
                            if (cc[ca] === cb) {
                                return true
                            }
                        }
                        return false
                    }
                }
            }
            return false
        };
        bi(b6);
        bZ.roistatSaveProxyFormSettings = b4
    })(a6, r);
    (function u() {
        if (a6.onRoistatAllModulesLoaded !== aI && typeof a6.onRoistatAllModulesLoaded === "function") {
            a6.onRoistatAllModulesLoaded()
        }
    })()
})(window, document, undefined);