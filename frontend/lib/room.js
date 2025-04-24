import { api, getLaravelCookie } from "./api";

export async function createRoom(formData){

    try {
        const response = await api.post('/api/rooms', formData, {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN'),
                'Content-Type': 'multipart/form-data',
            }
        })
        return response
    } catch (error){
        console.error(error.response);
    }
}