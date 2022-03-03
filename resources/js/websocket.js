const users = new Map();

const WebSocket = require('ws');
const wsServer = new WebSocket.Server({port: 9000});

wsServer.on('connection', onConnect);


function onConnect(wsClient) {
    console.log('Новый пользователь');
    let sender = wsClient;
    wsClient.on('close', function() {
        console.log('Пользователь отключился');
        users.delete(wsClient);
    });

    wsClient.on('message', function(message) {
        try {
            const jsonMessage = JSON.parse(message);
            switch (jsonMessage.action) {
                case 'connectToLobby':
                    users.set(wsClient, {
                        userName: jsonMessage.data.userName,
                        lobbyId:  jsonMessage.data.lobbyId,
                    });
                    break;
                case 'MSG':
                    wsServer.clients.forEach(client => {
                        if(users.get(sender).lobbyId === users.get(client).lobbyId) {
                            client.send(JSON.stringify({ msg: jsonMessage.data, sender: users.get(sender).userName }));
                        }
                    });
                    break;
                default:
                    console.log('Неизвестная команда');
                    break;
            }
        } catch (error) {
            console.log('Ошибка', error);
        }
    });
}
