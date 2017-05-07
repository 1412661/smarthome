#!/usr/bin/python
import sys,os
duration = sys.argv[1]
os.system('php /home/www-data/php/auto_cam.php '+duration+' &');