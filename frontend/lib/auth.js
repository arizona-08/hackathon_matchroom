import {api} from './api';
import { getCookie } from './api';

export async function register(credentials){
    try {
        const response = await api.post('/api/register', credentials, {
            headers: {
                "X-XSRF-TOKEN": getCookie('XSRF-TOKEN')
            }
        });
        return response;
    } catch (error){
        return error.response;
    }
}


export async function login(credentials){
    try {
        // va chercher les cookie et le token csrf
        await api.get('/sanctum/csrf-cookie');
        const response = await api.post('/api/login', credentials, {
            headers: {
                "X-XSRF-TOKEN": getCookie('XSRF-TOKEN')
            }
        });
        return response;
    } catch (error){
        return error.response;
    }
}

export async function logout(){
    try {
        const response = await api.post('/api/logout', {
            headers: {
                "X-XSRF-TOKEN": getCookie('XSRF-TOKEN')
            }
        });
        return response;
    } catch (error){
        return error.response;
    }
    

}