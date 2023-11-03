const Login = () => {
    return (
        <div className="max-w-default mx-auto">
            <div className="mt-4 p-8 border border-black border-solid">
                <h3 className="text-2xl font-semibold">Đăng nhập</h3>
                <div className="mt-4 text-lg flex flex-col gap-3">
                    <div className="flex items-center">
                        <label htmlFor="" className="w-40">
                            Last name
                        </label>
                        <input type="text" placeholder="lastname" className="bg-[#ccc]/30 py-1 px-2 rounded-md" />
                    </div>
                    <div className="flex items-center">
                        <label htmlFor="" className="w-40">
                            Mã đăng nhập
                        </label>
                        <input type="text" placeholder="code" className="bg-[#ccc]/30 py-1 px-2 rounded-md" />
                    </div>
                    <div className="flex items-center">
                        <div className="w-40"></div>
                        <button className="bg-sky-500 px-4 py-1 rounded-md text-white text-lg">Đăng nhập</button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Login;
