import { api, getLaravelCookie } from "./api";

export async function createRoom(room){
    try {
        const response = await api.post('/api/rooms', room, {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
            }
        })
        return response
    } catch (error){
        console.error(error.response);
    }
}