import React from 'react'
import { Link, Navigate, Outlet } from 'react-router-dom'
import { useUserContext } from '../contexts/UserContext'


const ClientLayout = () => {
    const { user, token } = useUserContext()
    if (token == null) {
        return <Navigate to="/login" />
    }
    return (

        <div>
            <Outlet />
        </div>
    )
}

export default ClientLayout