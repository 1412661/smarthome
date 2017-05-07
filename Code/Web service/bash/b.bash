#! /bin/bash
rootdevice=/dev/ttyUSB0
stty -F $rootdevice 115200 -icrnl -echo clocal

device1=/tmp/serial.1
device2=/tmp/serial.2

mkfifo $device1
mkfifo $device2

# we have to run the catcher before 
# launching the feeder


cat $rootdevice | tee -a $device1 | tee -a $device2 2>&1 1>/dev/null &