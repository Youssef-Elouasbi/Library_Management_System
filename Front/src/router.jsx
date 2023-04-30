import { Navigate, createBrowserRouter } from 'react-router-dom'
import Home from './pages/Client/Home'
import App from './App'
import GuestLayout from './Layouts/GuestLayout';
import NotFound from './pages/NotFound';
import ClientLayout from './Layouts/ClientLayout';
import AdminLayout from './Layouts/AdminLayout';
import Login from './pages/Client/Login';
import SignUp from './pages/Client/SignUp';
import LoginA from './pages/Admin/LoginA';
import Dashboard from './pages/Admin/Dashboard';

const router = createBrowserRouter([
    {
        // path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/login',
                element: <Login />
            },
            {
                path: '/admin/login',
                element: <LoginA />
            },
            {
                path: '/signup',
                element: <SignUp />
            },
        ]
    },
    {
        path: '/',
        element: <ClientLayout />,
        children: [
            {
                path: '/',
                element: <Navigate to="/home" />
            },
            {
                path: '/home',
                element: <Home />
            },

        ]
    },
    {
        // path: '/',
        element: <AdminLayout />,
        children: [
            {
                path: '/admin',
                element: <Navigate to="/dashboard" />
            },
            {
                path: '/dashboard',
                element: <Dashboard />
            },

        ]
    },
    {
        path: '*',
        element: <NotFound />
    },
])

export default router;