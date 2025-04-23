import { api, getLaravelCookie } from "./api";

export async function uploadPic(image){
    const formData = new FormData()
    formData.append('image', image)

    try {
        const response = await api.post('http://localhost:8000/api/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
            }
        })
        return response;
    } catch (error) {
        console.error('Upload failed:', error.response);
    }
}

export async function getProfilePic(){
    try {
        const response = await api.get('http://localhost:8000/api/get-profile-pic', {
            headers: {
                "X-XSRF-TOKEN": getLaravelCookie('XSRF-TOKEN')
            }
        });
        return response;
    } catch (error) {
        console.error('failed to fetch image:', error.response);
    }
}