let socket

function init() {
    socket = io("https://api.live.powerball.5min.winners-live.com", {
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

        let playlistElement = document.getElementById("playlist_"+ message.playlist_id);

        if(playlistElement){
            playlistElement.style.color = "green";
            playlistElement.style.display = "block";
        }

    });
}

init()