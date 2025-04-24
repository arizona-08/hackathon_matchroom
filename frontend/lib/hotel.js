import { api } from './api'
import { getCookie } from './api'

// export async function createHotel(hotelData) {
//     try {
//         // Ajouter le user_id à l'objet hotelData
//         const payload = {
//             ...hotelData,
//             user_id: 1 // user_id temporaire en attendant le login
//         }

//         const response = await api.post('/api/hotels', payload, {
//             headers: {
//                 "X-XSRF-TOKEN": getCookie('XSRF-TOKEN')
//             }
//         })
//         return response.data
//     } catch (error) {
//         console.error('[CREATE HOTEL ERROR]', error)
//         throw error.response?.data || error
//     }
// }

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
                "X-XSRF-TOKEN": getCookie('XSRF-TOKEN')
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
                "X-XSRF-TOKEN": getCookie('XSRF-TOKEN')
            }
        })
        return response.data
    } catch (error) {
        console.error('[DELETE HOTEL ERROR]', error)
        throw error.response?.data || error
    }
}
