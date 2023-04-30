import React from 'react'
import { useUserContext } from '../contexts/UserContext'
import { Navigate, Outlet } from 'react-router-dom'

const AdminLayout = () => {
    const { user, token } = useUserContext()
    if (!token) {
        return <Navigate to="/admin/login" />
    }
    return (
        <div>
            <Outlet />
        </div>
    )
}

export default AdminLayout