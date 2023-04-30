import { useRef, useState } from 'react'

import axiosClient from './axios-client';
import { useUserContext } from './contexts/UserContext';

function App() {
  const emailRef = useRef();
  const passwordRef = useRef();
  const [errors, setErrors] = useState({})
  const { setUser, setToken } = useUserContext()
  const onSubmit = (e) => {
    e.preventDefault()
    const payload = {
      email: emailRef.current.value,
      password: passwordRef.current.value,
    }
    axiosClient.post('/login', payload)
      .then(({ data }) => {
        const user = {
          id: data.user.id,
          name: data.user.name,
          email: data.user.email,
          role: data.user.role
        }
        setUser(user)
        setToken(data.token)
      })
      .catch(err => {
        if (err) { // validation error && err.response.status == 422
          setErrors(err.response.data)
        }
      })
  }
  return (
    <form onSubmit={onSubmit}>
      {
        errors && <div >
          {
            Object.keys(errors).map((key) => (
              <p key={key}> {errors[key]} </p>
            ))
          }
        </div>
      }
      <input ref={emailRef} type="email" placeholder='Email' />
      <input ref={passwordRef} type="password" placeholder='Password' />
      <input type="submit" value="Login" />
    </form>
  )
}

export default App
