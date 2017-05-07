#!/usr/bin/python
import serial
import os
import sys
import time
ser = serial.Serial('/dev/ttyUSB0', 115200, timeout=3.0) 
argv = sys.argv;
while 1:        
    stri = ser.readline()
    time.sleep(0.01)
    os.system("php /home/www-data/php/readserial.php '" + stri + "'")
