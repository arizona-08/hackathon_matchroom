import { api } from './api'
import { getLaravelCookie } from './api'

export async function createHotel(payload) {
    try {
      const response = await api.post('/api/hotels', payload)
      return response
    } catch (error) {
      console.error('[CREATE HOTEL ERROR]', error)
      throw error
    }
  }
  

export async function getAllHotels() {
    try {
        const response = await api.get('/api/hotels')
        return response.data
    } catch (error) {
        console.error('[GET HOTELS ERROR]', error)
        throw error
    }
}

export async function getHotel(id) {
    try {
        const response = await api.get(`/api/hotels/${id}`)
        return response.data
    } catch (error) {
        console.error('[GET HOTEL ERROR]', error)
        throw error
    }
}

export async function updateHotel(id, hotelData) {
    try {
        const response = await api.put(`/api/hotels/${id}`, hotelData, {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
            }
        })
        return response.data
    } catch (error) {
        console.error('[UPDATE HOTEL ERROR]', error)
        throw error.response?.data || error
    }
}

export async function deleteHotel(id) {
    try {
        const response = await api.delete(`/api/hotels/${id}`, {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
            }
        })
        return response.data
    } catch (error) {
        console.error('[DELETE HOTEL ERROR]', error)
        throw error.response?.data || error
    }
}

export async function generateHotelKeyForUser(userId) {
    try {
      const response = await api.post('/api/generate-hotel-key', { user_id: userId });
      return response.data;
    } catch (error) {
      console.error('[GENERATE HOTEL KEY ERROR]', error);
      throw error.response?.data || error;
    }
  }
  