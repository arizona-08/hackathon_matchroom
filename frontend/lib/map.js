import { api } from './api';

/**
 * Récupère les données pour afficher les hôtels et les chambres sur la carte.
 */
export async function getMapData() {
  return await api.get('/api/map-data')
}
