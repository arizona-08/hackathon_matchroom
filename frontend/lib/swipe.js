import { api, getLaravelCookie } from './api';
import { addToFavoris } from './favoris';

export async function swipe(userId, currentRoom, nextRoom, action) {
    if (!currentRoom.value) return;

    try {
        const response = await api.post('api/swipes', {
            user_id: userId,
            room_id: currentRoom.value.id,
            action: action,
        }, {
            headers: { "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN') }
        });

        if (action === 'like') {
            await addToFavoris(currentRoom.value.id);
        }

        nextRoom();
        return response;
    } catch (error) {
        console.error('Erreur en envoyant le swipe:', error);
        return error.response;
    }
}
