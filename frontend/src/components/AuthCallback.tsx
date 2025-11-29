import { useEffect, useRef } from "react";
import { useNavigate, useSearchParams } from "react-router-dom"

const AuthCallback = () => {
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const processed = useRef(false);

  useEffect(() => {
    if (processed.current) return;
    processed.current = true;

    const token = searchParams.get('token');

    if (token) {
      localStorage.setItem('auth_token', token);

      navigate('/dashboard', { replace: true });
    } else {
      navigate("/login?error=auth_failed", { replace: true });
    }
  }, [searchParams, navigate]);

  return (
    <div className="flex flex-col items-center justify-center min-h-screen bg-gray-50">
      <div className="text-center">
        <h2 className="text-xl font-semibold text-gray-700 mb-2">Processing Login...</h2>
        <p className="text-gray-500">Please wait while we authenticate you.</p>
        
        <div className="mt-6 flex justify-center">
          <div className="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600"></div>
        </div>
      </div>
    </div>
  );
}

export default AuthCallback;