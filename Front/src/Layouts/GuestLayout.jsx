import React from 'react'
import { Navigate, Outlet } from 'react-router-dom'
import { useUserContext } from '../contexts/UserContext'

const GuestLayout = () => {
    const { user, token } = useUserContext()

    if (token != null) {
        return user.role == "client" ? <Navigate to="/home" /> : <Navigate to="/dashboard" />
    }
    return (
        <div>
            guest
            <Outlet />
        </div>
    )



}

export default GuestLayout