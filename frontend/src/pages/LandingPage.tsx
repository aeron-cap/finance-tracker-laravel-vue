import Login from "@/components/Login";
import { Button } from "@/components/ui/button";

export default function LandingPage() {
  return (
    <div className="h-screen flex items-center justify-center relative overflow-hidden bg-slate-50">
      
      <div className="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-blue-300/40 blur-[100px] mix-blend-multiply animate-blob" />
      <div className="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-green-300/40 blur-[100px] mix-blend-multiply animate-blob animation-delay-2000" />
      <div className="absolute top-[20%] right-[20%] w-[400px] h-[400px] rounded-full bg-red-300/40 blur-[100px] mix-blend-multiply animate-blob animation-delay-4000" />
      <div className="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/60 via-transparent to-transparent" />

      <div className="relative z-10 container mx-auto px-4 flex justify-center">
        <div className="
          max-w-4xl w-full p-8 md:p-12
          bg-white/30
          backdrop-blur-md
          border border-white/50
          shadow-[0_8px_32px_0_rgba(31,38,135,0.15)]
          rounded-3xl
          text-center
          "
        >
          <h1 className="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl text-slate-900">
            Smart finance for <br />
            <span className="text-green-600">myself (for now).</span>
          </h1>
          
          <p className="pt-5 mx-auto max-w-[700px] text-lg text-slate-600 md:text-xl">
            Track expenses, visualize investments, and master your budget with 
            analytics powered by <b>Finance++</b>. The personal finance tool built for efficiency.
          </p>
          
          <div className="flex flex-col sm:flex-row justify-center gap-4 pt-4 cursor-pointer">
            <Login>
              <Button
                variant="outline"
                size="lg" 
                className="
                  bg-green-600 
                  hover:bg-green-700 
                  text-white 
                  font-bold 
                  text-lg 
                  px-8 
                  shadow-lg 
                  hover:shadow-green-500/30 
                  transition-all 
                  duration-300 
                  group"
              >
                Get Started
              </Button>
            </Login>
          </div> 
        </div>
      </div>
    </div>
  )
}