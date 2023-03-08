import shutil
import os.path
import sys
import json

#Need path from api
selectedfileNames = json.loads(sys.argv[1])
playlistTrackIds = json.loads(sys.argv[2])

# get video file from source file and save it in temp file and rename according to the user input play list order

sourcePath = sys.argv[3]
tempPath =  sys.argv[4]
destinationPath = sys.argv[5]

playlist_id = sys.argv[6]

if not os.path.exists(destinationPath):
    os.mkdir(destinationPath)
    print("Directory " , destinationPath ,  " Created ")
else:    
    print("Directory " , destinationPath ,  " already exists")

for playlistTrackId , file_name in enumerate(selectedfileNames):
    sourceFilePath = file_name
    # tempFilePath = tempPath + str(playlistTrackIds[playlistTrackId]) + ".mp4"
    # shutil.copy(sourceFilePath, tempFilePath)
    des = destinationPath + str(playlist_id) + "_" + str(playlistTrackIds[playlistTrackId]) + ".mp4"
    shutil.copy(sourceFilePath, des)

#tempFiles = os.listdir(tempPath)

# for tempFileName in tempFiles:
#     tempFilePath = tempPath + tempFileName
#     destinationFilePath = destinationPath + tempFileName

#     if os.path.isfile(destinationFilePath):
#         os.remove(destinationFilePath)

#     shutil.move(tempFilePath, destinationFilePath)
