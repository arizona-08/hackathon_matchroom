import { api, getLaravelCookie } from "./api";

export async function getAuthUser(){
    try {  
        const response = await api.get('/api/user', {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
            }
        });
        return response;
    } catch (error){
        return error.response;
    }
}