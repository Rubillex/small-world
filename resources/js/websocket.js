/**
 * User: Rubillex
 * Date: 22.02.2022 18:18
 */

const WebSocket = require('ws');
const wsServer = new WebSocket.Server({port: 9000});

wsServer.on('connection', onConnect);


function onConnect(wsClient) {
    //todo вырезат
    console.log('Новый пользователь');

    wsClient.on('close', function() {
        console.log('Пользователь отключился');
    });

    wsClient.on('message', function(message) {
        console.log(message);
        try {
            const jsonMessage = JSON.parse(message);
            switch (jsonMessage.action) {
                case 'ECHO':
                    // wsClient.send(jsonMessage.data);
                    break;
                case 'MSG':
                    wsServer.clients.forEach(client => {
                        if(client != wsClient)
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
