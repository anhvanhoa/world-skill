import { Link } from 'react-router-dom';
const Home = () => {
    return (
        <div className="max-w-default mx-auto">
            <header className="border-b border-gray-500 border-solid">
                <div className="flex items-center justify-between p-4">
                    <h1 className="text-3xl font-semibold">Nền tảng đặt sự kiện</h1>
                    <Link to="/login" className="bg-sky-500 px-4 py-1 rounded-md text-white text-lg">
                        Đăng nhập
                    </Link>
                    {/* <div className="flex items-center gap-4">
                        <p className="font-medium">Anh Van Hoa</p>
                        <button className="bg-red-500 px-4 py-1 rounded-md text-white text-lg">Đăng xuất</button>
                    </div> */}
                </div>
            </header>
            <div>
                <Link className="mt-5" to="/react-conf-2019">
                    <div className="p-4 bg-[#ccc]/20 rounded-md mt-5">
                        <h2 className="text-xl font-semibold">React conf 2019</h2>
                        <div className="flex items-center">
                            <p>organizerDemo</p>
                            <p className="mr-1">,</p>
                            <p>ngày 02-12-2023</p>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    );
};

export default Home;
