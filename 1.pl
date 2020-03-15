#!/usr/bin/perl

=com
        Created by Belobrov Miahil
    mihail[dot]belobrob[at]gmail.com
=cut
                
use strict;
use warnings;
use File::stat;
use File::Basename;
use Getopt::Std; 
   
my $in_audioname_in=$ARGV[0];
my $in_audioname_out=$ARGV[1];
my $rec_id=$ARGV[2];  

my $in_audioname_in_p = "/var/www/neiros/data/www/cloud.neiros.ru/public/audiorecord/$in_audioname_in";
my $in_audioname_out_p = "/var/www/neiros/data/www/cloud.neiros.ru/public/audiorecord/$in_audioname_out";
my $min_size = '500';



system("/usr/bin/ffmpeg -i $in_audioname_in_p -acodec pcm_s16le -ac 1 -ar 16000 $in_audioname_in_p.wav");
system("/usr/bin/ffmpeg -i $in_audioname_out_p -acodec pcm_s16le -ac 1 -ar 16000 $in_audioname_out_p.wav");

system("/usr/local/bin/asrclient-cli.py --key=6a6edf5e-b9c7-4ea1-a308-be7a26249d5d  --silent  $in_audioname_in_p.wav >$in_audioname_in_p.txt");
system("/usr/local/bin/asrclient-cli.py --key=6a6edf5e-b9c7-4ea1-a308-be7a26249d5d  --silent  $in_audioname_out_p.wav > $in_audioname_out_p.txt");
system("/opt/php72/bin/php  /var/www/neiros/data/www/cloud.neiros.ru/artisan command:texttobase $rec_id ")