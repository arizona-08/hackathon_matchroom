import axios from 'axios';
const BACKEND_SERVICE = process.env.BACKEND_SERVICE || "http://localhost:8000";

export const api = axios.create({
    baseURL: BACKEND_SERVICE,
    withCredentials: true,
})

export function getLaravelCookie(name){
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
        const part = parts.pop();
        return part ? part.split(';').shift() ?? '' : '';
    }
}