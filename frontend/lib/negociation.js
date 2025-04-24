import { api } from './api'

export async function getUserNegotiations() {
  const response = await api.get('/api/negotiations')
  return response.data
}

export async function getHotelierNegotiations() {
  const response = await api.get('/api/negotiations/hotelier/requests')
  return response.data
}

export async function startNegotiation(payload) {
  const response = await api.post('/api/negotiations', payload)
  return response
}

export async function getNegotiationHistoryByRoom(roomId) {
  const response = await api.get(`/api/negotiations/room/${roomId}`)
  return response.data
}

export async function submitNewOffer(room_id, proposed_price) {
  const userRes = await api.get('/api/user')
  const user_id = userRes.data.id

  return await api.post('/api/negotiations', {
    room_id,
    user_id,
    proposed_price
  })
}

export async function submitCounterOffer(negotiationId, proposed_price) {
  const userRes = await api.get('/api/user')
  const user_id = userRes.data.id

  const response = await api.post(`/api/negotiations/${negotiationId}/propose-price`, {
    proposed_price,
    user_id
  })

  return response
}


export async function submitInitialOffer(room_id, proposed_price) {
  const userRes = await api.get('/api/user')
  const user_id = userRes.data.id

  const response = await api.post('/api/negotiations', {
    room_id,
    user_id,
    proposed_price
  })

  return response
}


export async function acceptNegotiation(negotiationId) {
  return api.post(`/api/negotiations/${negotiationId}/accept`)
}

export async function declineNegotiation(negotiationId) {
  return api.post(`/api/negotiations/${negotiationId}/decline`)
}
