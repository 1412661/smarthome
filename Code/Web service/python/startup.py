#! /usr/bin/python
import os
import RPi.GPIO as GPIO
os.system('sudo chmod 777 /dev/ttyUSB0')

os.system('sudo stty -F /dev/ttyUSB0 115200 raw')

os.system('sudo mjpg_streamer -i "/usr/local/lib/input_uvc.so -n -f 30 -r 160x120" -o "/usr/local/lib/output_http.so -p 4 -n -w /usr/local/www" -b')

os.system('sudo python /home/www-data/python/readserial.py &')
os.system('sudo php /home/www-data/php/update_sys_info.php &')
os.system('sudo php /home/www-data/php/auto_cam.php &')
#os.system('sudo /usr/local/bin/noip2')

GPIO.setmode(GPIO.BOARD)
GPIO.setup(7,GPIO.OUT)
GPIO.output(7,True)
GPIO.cleanup()

print "SmartHome is started ..."
