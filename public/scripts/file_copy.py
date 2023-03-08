import shutil
import os.path
import sys
import json

sourceFilePath = sys.argv[1]
destinationFilePath = sys.argv[2]
destinationFilePathDir = sys.argv[3]

if not os.path.exists(destinationFilePathDir):
    os.mkdir(destinationFilePathDir)
    shutil.copy(sourceFilePath, destinationFilePath)
else:    
    shutil.copy(sourceFilePath, destinationFilePath)
