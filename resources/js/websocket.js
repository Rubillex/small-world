/**
 * User: Rubillex
 * Date: 22.02.2022 18:18
 */

const users = new Map();

const WebSocket = require('ws');
const wsServer = new WebSocket.Server({port: 9000});

wsServer.on('connection', onConnect);


function onConnect(wsClient) {
    //todo вырезат
    console.log('Новый пользователь');


    wsClient.on('close', function() {
        console.log('Пользователь отключился');
        users.delete(wsClient);
        console.log('Список пользователей');
        for (let pair of users.entries()) {
            // pair - это массив [key, values]
            console.log(`Ключ = ${pair[0]}, значение = ${pair[1]}`);
        }
    });

    wsClient.on('message', function(message) {
        console.log(JSON.parse(message));
        try {
            const jsonMessage = JSON.parse(message);
            switch (jsonMessage.action) {
                case 'CONNECT':
                    users.set(wsClient, jsonMessage.lobby_id); // USERNAME, LobbyID
                    console.log(jsonMessage.lobby_id);
                    console.log('Список пользователей');
                    for (let pair of users.entries()) {
                        // pair - это массив [key, values]
                        console.log(`Ключ = ${pair[0]}, значение = ${pair[1]}`);
                    }
                    break;
                case 'MSG':
                    wsServer.clients.forEach(client => {
                        if(client != wsClient && users.get(wsClient) == users.get(client))
                        client.send(jsonMessage.data);
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
