import React from 'react'
import ReactDOM from 'react-dom/client'
import router from './router.jsx'
import '../node_modules/bootstrap/dist/css/bootstrap.min.css';
import { UserProvider } from './contexts/UserContext.jsx'
import { RouterProvider } from 'react-router-dom'

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <UserProvider>
      <RouterProvider router={router} />
    </UserProvider>
  </React.StrictMode>,
)
