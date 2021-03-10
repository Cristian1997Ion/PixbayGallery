import axios from "axios";
export default () => {
    const instance = axios.create({
        baseURL: '/api/',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    instance.interceptors.response.use(response => {
        return response;
    }, error => {
        return Promise.reject(error);
    })

    return instance;
}
