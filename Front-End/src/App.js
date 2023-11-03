import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from './pages/Home';
import Event from './pages/Event';
import RegisterEvent from './pages/RegisterEvent';
import Login from './pages/Login';
function App() {
    return (
        <div className="App">
            <BrowserRouter>
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/login" element={<Login />} />
                    <Route path="/:slug" element={<Event />} />
                    <Route path="/register-event/:event" element={<RegisterEvent />} />
                </Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;
