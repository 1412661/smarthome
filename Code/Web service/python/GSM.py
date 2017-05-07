#!/usr/bin/python
import serial
import os
import sys
import time
ser = serial.Serial('/dev/ttyUSB1', 115200, timeout=3.0) 
argv = sys.argv;
ser.write("GSM_SEND " + argv[1] + " " + argv[2] + "\r\n")