import os
import sys
import json
import shutil

file_path = sys.argv[1]

if os.path.exists(file_path):
    shutil.rmtree(file_path)
    print('Deleting file:', file_path)
 
else:
    print("wrong file")
