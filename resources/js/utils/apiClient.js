import axios from "axios";
export default () => {
    const instance = axios.create({
        baseURL: '/api/',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    instance.interceptors.request.use(fulfilled => {
        console.log('api request in progress...');
        return fulfilled;
    }, rejected => {
        console.log('api request rejected');
        return rejected
    })

    instance.interceptors.response.use(response => {
        console.info('api request done');
        return response;
    }, error => {
        console.log('api request failed :(')
        return Promise.reject(error);
    })

    return instance;
}
