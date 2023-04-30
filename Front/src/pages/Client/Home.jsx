import React, { useRef } from 'react'
import axiosClient from '../../axios-client';

const Home = () => {
    // const nameRef = useRef();
    // const logout = () => {
    //     axiosClient.get('/logout')
    // }
    // const onSubmit = (e) => {
    //     e.preventDefault()
    //     const payload = {
    //         name: nameRef.current.value,
    //     }
    //     axiosClient.post('/categories', payload)
    //         .then(({ data }) => {
    //             console.log(data)
    //         })
    //         .catch(err => {
    //             console.log(err.response.data)
    //         })
    // }
    return (
        <div>
            <h1>Home</h1>
            {/* <button onClick={logout}>Logout</button>
            <br />
            <br />
            <br />
            <form onSubmit={onSubmit}>
                <input ref={nameRef} type="text" placeholder='name' />
                <input type="submit" value="Add" />
            </form> */}
        </div>
    )
}

export default Home