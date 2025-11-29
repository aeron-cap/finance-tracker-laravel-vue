import { createBrowserRouter } from "react-router-dom";
import AuthCallback from "./components/AuthCallback";
import LandingPage from "./pages/LandingPage";

export const router = createBrowserRouter([
  {
    path: "/auth/callback",
    element: <AuthCallback />,
  },
  {
    path: "/",
    element: <LandingPage />,
  }
]);