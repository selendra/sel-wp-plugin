 import { v4 as uuidv4 } from "https://jspm.dev/uuid";
            import { io } from "https://cdn.socket.io/4.3.2/socket.io.esm.min.js";

            const endpoint = "https://auth-student.selendra.org"
            const socket = io(endpoint);
            window.socket = socket;

            const ssocket = io(endpoint, {
                extraHeaders: {
                    authorization: "dummytoken" ,
                },
            });
            window.ssocket = ssocket;

            ssocket.on("connect", () => {
            });

            const QrID = { id: uuidv4() };

            window.QrID = QrID;

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

