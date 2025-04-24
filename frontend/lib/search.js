import { api, getLaravelCookie } from './api'

export async function getUserFilters(userId) {
  return await api.get(`/api/search-preset?user_id=${userId}`)
}

export async function createSearchPreset(payload) {
  return await api.post('/api/search-preset', payload, {
    headers: {
      "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
    }
  })
}

export async function runSearchPreset(presetId) {
  return await api.get(`/api/search-preset/${presetId}/run`)
}
