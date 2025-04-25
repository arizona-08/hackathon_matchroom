import { api, getLaravelCookie } from './api';

export async function addToFavoris(roomId) {
  try {
    await api.post('api/favoris', { room_id: roomId }, {
      headers: {
        "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
      }
    });
  } catch (error) {
    console.error('Erreur en ajoutant aux favoris :', error);
  }
}

export async function getFavoris() {
  try {
    const response = await api.get('api/favoris', {
      headers: {
        "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
      }
    });
    return response.data;
  } catch (error) {
    console.error('Erreur en récupérant les favoris :', error);
    return [];
  }
}

export async function removeFavori(favoriId) {
  try {
    await api.delete(`api/favoris/${favoriId}`, {
      headers: {
        "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
      }
    });
  } catch (error) {
    console.error('Erreur en supprimant le favori :', error);
  }
}
