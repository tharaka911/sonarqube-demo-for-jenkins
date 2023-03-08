import sys

from xml.dom import minidom

import os

root = minidom.Document()

xml = root.createElement('playlist')
xml.setAttribute('xmlns', 'http://xspf.org/ns/0/')
xml.setAttribute('xmlns:vlc', 'http://www.videolan.org/vlc/playlist/ns/0/')
xml.setAttribute('version', '1')
root.appendChild(xml)

base_url = sys.argv[1]
save_path = sys.argv[2]
playList_range = sys.argv[3]
waitingVideoUrl = sys.argv[4]
playlist_id = sys.argv[5]

productChild = root.createElement('trackList')
xml.appendChild(productChild)

for num in range (1, int(playList_range),2):

    childOfProduct = root.createElement('track')
    productChild.appendChild(childOfProduct)

    childOf2Product = root.createElement('location')
    childOf2Product.appendChild(root.createTextNode(str(waitingVideoUrl)))
    childOfProduct.appendChild(childOf2Product)

    childOf2Product = root.createElement('duration')
    childOf2Product.appendChild(root.createTextNode('104012'))
    childOfProduct.appendChild(childOf2Product)

    childOf2Product = root.createElement('extension')
    childOf2Product.setAttribute('application', 'http://www.videolan.org/vlc/playlist/0')
    childOfProduct.appendChild(childOf2Product)

    childOf3Product = root.createElement('vlc:id')
    childOf3Product.appendChild(root.createTextNode(str(num)))
    childOf2Product.appendChild(childOf3Product)

    childOfProduct = root.createElement('track')
    productChild.appendChild(childOfProduct)

    childOf2Product = root.createElement('location')
    childOf2Product.appendChild(root.createTextNode(str(base_url)+ str(playlist_id) + "_" + str(num+1)+'.mp4'))
    childOfProduct.appendChild(childOf2Product)

    childOf2Product = root.createElement('duration')
    childOf2Product.appendChild(root.createTextNode('104012'))
    childOfProduct.appendChild(childOf2Product)

    childOf2Product = root.createElement('extension')
    childOf2Product.setAttribute('application','http://www.videolan.org/vlc/playlist/0')
    childOfProduct.appendChild(childOf2Product)

    childOf3Product = root.createElement('vlc:id')
    childOf3Product.appendChild(root.createTextNode(str(num+1)))
    childOf2Product.appendChild(childOf3Product)

productChild = root.createElement('extension')
productChild.setAttribute('application','http://www.videolan.org/vlc/playlist/0')
xml.appendChild(productChild)

for number in range (1,int(playList_range)):
    childOfProduct = root.createElement('vlc:id')
    childOfProduct.setAttribute('tid', str(number))
    productChild.appendChild(childOfProduct)


xml_str = root.toprettyxml(indent="\t")

save_path_file = save_path

with open(save_path_file, "w") as f:
    f.write(xml_str)
    print("success")