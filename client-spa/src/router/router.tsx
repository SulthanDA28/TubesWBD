import { createBrowserRouter, RouterProvider } from 'react-router-dom'
import Login from '../component/Login'
import TweetAnalytic from '../component/TweetAnalytic'
import Home from '../component/Home'
import Register from '../component/Register'
import SelectCompare from '../component/SelectCompare'
import Compare from '../component/Compare'

const routesList = createBrowserRouter([
    {
        path: '/login',
        element: <Login />,
    },
    {
        path: '/home',
        element: <Home />,
    },
    {
        path: '/tweet-analytic?',
        element: <TweetAnalytic />,
    },
    {
        path: '/register',
        element: <Register />,
    },
    {
        path: '/',
        element: <Login />,
    },
    {
        path: '/compare',
        element: <SelectCompare />,
    },
    {
        path: '/compare/content?',
        element: <Compare />,
    },
    
  ])
  
  const Routes = () => {
    return <RouterProvider router={routesList} />
  }
  
  export default Routes