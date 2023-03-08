import os
import sys
import json

file_path = sys.argv[1]

if os.path.exists(file_path):
    print('Deleting file:', file_path)
    os.remove(file_path)
else:
    print("wrong file")
