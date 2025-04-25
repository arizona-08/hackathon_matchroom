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

export async function updateRoomWithPic(formData, room_id){

    try {
        const response = await api.post(`/api/rooms-pic/${room_id}`, formData, {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN'),
                // 'Content-Type': 'multipart/form-data',
            }
        })
        return response
    } catch (error){
        console.error(error.response);
    }
}

export async function updateRoom(data, room_id){

    try {
        const response = await api.put(`/api/rooms/${room_id}`, data, {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN'),
            }
        })
        return response
    } catch (error){
        console.error(error.response);
    }
}

export async function getAllRooms(){
    try {
        const response = await api.get('/api/rooms')
        return response
    } catch (error) {
        console.error('[GET ROOMS ERROR]', error)
        throw error
    }
}

export async function getSameHotelRoom(hotel_id){
    try {
        const response = await api.get(`/api/rooms/from-hotel/${hotel_id}`)
        return response
    } catch (error) {
        console.error('[GET ROOMS ERROR]', error)
        throw error
    }
}

export async function getRoom(id){
    try {
        const response = await api.get(`/api/rooms/${id}`)
        return response
    } catch (error) {
        console.error('[GET ROOM ERROR]', error)
        throw error
    }
}

export async function getRoomSimple(id){
    try {
        const response = await api.get(`/api/rooms-simple/${id}`)
        return response
    } catch (error) {
        console.error('[GET ROOM ERROR]', error)
        throw error
    }
}

export async function deleteRoom(id){
    try {
        const response = await api.delete(`/api/rooms/${id}`, {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN'),
            }
        })
        return response
    } catch (error) {
        console.error('[DELETE ROOM ERROR]', error)
        throw error
    }
}