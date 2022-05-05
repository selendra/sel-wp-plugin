 import { v4 as uuidv4 } from "https://jspm.dev/uuid";
            import { io } from "https://cdn.socket.io/4.3.2/socket.io.esm.min.js";

            const endpoint = "http://137.184.224.174:4000";
            const socket = io(endpoint);
            window.socket = socket;

            const ssocket = io(endpoint, {
                extraHeaders: {
                    authorization: "dummytoken" ,
                },
            });
            window.ssocket = ssocket;

            var QrID = { id: uuidv4() };

            function broadcastinfo(data) {

            socket.on("connect", () => {
 //               socket.emit("/auth/qr-request", data);
            });

            }

/*
            socket.on("/auth/approved", ({ token }) => {
                alert("approved");
                if (token) {
                    window.localStorage.setItem("token", token);
                    window.location.replace("/");
                }
            });
*/
           export {broadcastinfo };

