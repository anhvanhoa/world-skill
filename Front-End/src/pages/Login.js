import { useState, useContext } from 'react';
import { contextUser } from '../store/ProviderUser';
import { useNavigate } from 'react-router-dom';
const Login = () => {
    const { setUser } = useContext(contextUser);
    const navigate = useNavigate();
    const [dataForm, setDataForm] = useState({ lastname: '', registration_code: '' });
    const changeLastName = (event) => setDataForm((prev) => ({ ...prev, lastname: event.target.value }));
    const changeCode = (event) => setDataForm((prev) => ({ ...prev, registration_code: event.target.value }));
    const handleLogin = () => {
        const url = process.env.REACT_APP_REQUESTS;
        fetch(`${url}/login`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
            body: JSON.stringify(dataForm),
        })
            .then((res) => res.json())
            .then((data) => {
                setUser(data);
                navigate('/');
            })
            .catch((error) => console.log(error));
    };
    return (
        <div className="max-w-default mx-auto">
            <div className="mt-4 p-8 border border-black border-solid">
                <h3 className="text-2xl font-semibold">Đăng nhập</h3>
                <form onSubmit={(e) => e.preventDefault()} className="mt-4 text-lg flex flex-col gap-3">
                    <div className="flex items-center">
                        <label htmlFor="" className="w-40">
                            Last name
                        </label>
                        <input
                            value={dataForm.lastname}
                            onChange={changeLastName}
                            type="text"
                            placeholder="lastname"
                            className="bg-[#ccc]/30 py-1 px-2 rounded-md"
                        />
                    </div>
                    <div className="flex items-center">
                        <label htmlFor="" className="w-40">
                            Mã đăng nhập
                        </label>
                        <input
                            value={dataForm.registration_code}
                            onChange={changeCode}
                            type="password"
                            placeholder="code"
                            className="bg-[#ccc]/30 py-1 px-2 rounded-md"
                        />
                    </div>
                    <div className="flex items-center">
                        <div className="w-40"></div>
                        <button
                            onClick={handleLogin}
                            type="submit"
                            className="bg-sky-500 px-4 py-1 rounded-md text-white text-lg"
                        >
                            Đăng nhập
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Login;
