import { Navigate, createBrowserRouter } from 'react-router-dom'
import Home from './Home'
import App from './App'
import DefaultLayout from './components/DefaultLayout';
import GuestLayout from './components/GuestLayout';
import NotFound from './NotFound';

const router = createBrowserRouter([
    {
        path: '/',
        element: <DefaultLayout />,
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
        path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/login',
                element: <App />
            },
        ]
    },
    {
        path: '*',
        element: <NotFound />
    },
])

export default router;