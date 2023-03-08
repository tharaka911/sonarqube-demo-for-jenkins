let socket

function init() {
    socket = io("https://api.live.powerball.3min.winners-live.com", {
        transports: ["websocket", "polling"],
    });

    socket.on("connect", () => {

        console.log(`[socket] Connected`);
    });

    socket.on("disconnect", () => {
        console.log("[socket] Disconnected");
    });

    // TODO: need to check [reconnection_attempt]
    socket.io.on("reconnection_attempt", () => {
        console.log("[socket] Try to Reconnect");
    });

    socket.io.on("reconnect", () => {
        console.log("[socket] Re-connected");
    });

    socket.on("GET_VIDEO_DATA", (message) => {
        let myElement = document.getElementById("indicator");
        
        let track_id = message.track_id

        currentTrack = Number((message.next_track_id)-2);
        console.log(currentTrack);
        let current_track = document.getElementById(currentTrack);
        let next_track = document.getElementById(parseInt(currentTrack)+2);
        const liitems = document.getElementsByClassName("liitems");

       
        for (let i = 0; i < liitems.length; i++) {
            if (i === currentTrack/2 -1) {
                liitems[i].style.backgroundColor = "pink";
              }else{if(i < currentTrack/2){
                liitems[i].style.backgroundColor = "paleturquoise";
                }else{
                    liitems[i].style.backgroundColor = "#f5f5f5";
            }
        }
        }  

        if(current_track){
            current_track.style.color = "red";
            current_track.style.display = "block";
        }

        if(next_track){
            next_track.style.display = "block";
            next_track.style.color = "green";
        }

        if(track_id>2){
            document.getElementById(parseInt(track_id)-2).style.display = "none";
        }
        

        if (message.playlist_id == playlist_id) {

            myElement.innerHTML = message.track_id;

            // if(!isNaN(track_id)){
        
            //     let current_track = document.getElementById(track_id);
            //     let next_track = document.getElementById(parseInt(track_id)+2);
    
            //     if(current_track){
            //         current_track.style.color = "red";
            //         current_track.style.display = "block";
            //     }
    
            //     if(next_track){
            //         next_track.style.display = "block";
            //         next_track.style.color = "green";
            //     }
    
            //     if(track_id>2){
            //         document.getElementById(parseInt(track_id)-2).style.display = "none";
            //     }
            // }
        }else{
            myElement.innerHTML = "Offline";
        }
        
    });
}

init()