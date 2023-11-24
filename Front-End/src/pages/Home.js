import { useEffect, useState, useContext } from 'react';
import { contextUser } from '../store/ProviderUser';
import { Link } from 'react-router-dom';
const Home = () => {
    const { user, setUser } = useContext(contextUser);
    const [data, setData] = useState([]);
    const url = process.env.REACT_APP_REQUESTS;
    useEffect(() => {
        const events = fetch(`${url}/events`);
        events.then((res) => res.json()).then((data) => setData(data));
    }, [url]);
    const handleLogout = () => {
        fetch(`${url}/logout?token=${user.token}`, {
            method: 'POST',
            mode: 'cors',
            headers: {
                'Content-type': 'application/json',
            },
        })
            .then((res) => res.json())
            .then((data) => console.log(data));
        setUser(null);
    };
    return (
        <div className="max-w-default mx-auto">
            <header className="border-b border-gray-500 border-solid">
                <div className="flex items-center justify-between p-4">
                    <h1 className="text-3xl font-semibold">Nền tảng đặt sự kiện</h1>
                    {user ? (
                        <div className="flex items-center gap-4">
                            <p className="font-medium">
                                {user?.firstname} {user?.lastname}
                            </p>
                            <button
                                onClick={handleLogout}
                                className="bg-red-500 px-4 py-1 rounded-md text-white text-lg"
                            >
                                Đăng xuất
                            </button>
                        </div>
                    ) : (
                        <Link to="/login" className="bg-sky-500 px-4 py-1 rounded-md text-white text-lg">
                            Đăng nhập
                        </Link>
                    )}
                </div>
            </header>
            <div>
                {data.map(({ organizer, ...element }) => (
                    <Link key={element.id} className="mt-5" to={`/organizer/${organizer.slug}/event/${element.slug}`}>
                        <div className="p-4 bg-[#ccc]/20 rounded-md mt-5">
                            <h2 className="text-xl font-semibold">{element.name}</h2>
                            <div className="flex items-center">
                                <p>{organizer.name}</p>
                                <p className="mr-1">,</p>
                                <p>
                                    <span className="pr-1">Ngày</span>
                                    {new Date(element.date).toLocaleString('vi', {
                                        day: 'numeric',
                                        month: 'numeric',
                                        year: 'numeric',
                                    })}
                                </p>
                            </div>
                        </div>
                    </Link>
                ))}
            </div>
        </div>
    );
};

export default Home;
