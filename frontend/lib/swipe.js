import { api, getLaravelCookie } from './api';

export async function swipe(userId, currentRoom, nextRoom, action) {
    if (!currentRoom.value) return;

    try {
        const response = await api.post('/swipes', {
            user_id: userId,
            room_id: currentRoom.value.id,
            action: action,
        }, {
            headers: { "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN') }
        });

        nextRoom();
        return response;
    } catch (error) {
        console.error('Erreur en envoyant le swipe:', error);
        return error.response;
    }
}
