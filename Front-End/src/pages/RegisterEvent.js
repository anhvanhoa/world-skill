import TypeTicket from '../components/TypeTicket';
import OptionWorkshop from '../components/OptionWorkshop';
import { contextUser } from '../store/ProviderUser';
import { useEffect, useState, useContext } from 'react';
import { useParams, useNavigate } from 'react-router-dom';

const RegisterEvent = () => {
    const { user } = useContext(contextUser);
    const navigate = useNavigate();
    const params = useParams();
    const [data, setData] = useState({ channels: [{ rooms: [{ sessions: [] }] }], tickets: [] });
    const url = process.env.REACT_APP_REQUESTS;
    useEffect(() => {
        const events = fetch(`${url}/organizers/${params.organizer}/events/${params.event}`);
        events.then((res) => res.json()).then((data) => setData(data));
    }, [params.event, params.organizer, url]);
    const [checkTicket, setCheckTicket] = useState(0);
    const [checkWorkshop, setCheckWorkshop] = useState([]);
    const [bill, setBill] = useState({
        ticketPrice: 0,
        workshop: 0,
    });
    const changeCheckTicket = (id, price) => {
        setCheckTicket(id);
        setBill((prev) => ({ ...prev, ticketPrice: -Number(price) }));
    };
    const changeCheckWorkshop = (id, price) => {
        if (checkWorkshop.includes(id)) {
            setCheckWorkshop(checkWorkshop.filter((elem) => elem !== id));
            setBill((prev) => ({ ...prev, workshop: prev.workshop + Number(price) }));
        } else {
            setCheckWorkshop((prev) => [...prev, id]);
            setBill((prev) => ({ ...prev, workshop: prev.workshop - price }));
        }
    };
    const handleBuy = () => {
        if (!user?.token) {
            navigate('/login');
            return;
        }
        fetch(`${url}/organizers/${params.organizer}/events/${params.event}/registration?token=${user.token}`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
            body: JSON.stringify({
                ticket_id: checkTicket,
                session_ids: checkWorkshop,
            }),
        })
            .then((res) => res.json())
            .then((data) => console.log(data));
    };
    return (
        <div>
            <div className="max-w-5xl mx-auto">
                <header>
                    <div className="flex items-center justify-between p-4">
                        <h1 className="text-3xl font-semibold">{data.name}</h1>
                    </div>
                </header>
                <div className="p-4">
                    <div className="grid grid-cols-3">
                        {data.tickets.map((item) => (
                            <TypeTicket
                                key={item.id}
                                available={item.available}
                                price={item.cost}
                                name={item.name}
                                checked={item.id === checkTicket}
                                onChange={() => changeCheckTicket(item.id, item.cost)}
                            />
                        ))}
                    </div>
                    <div className="mt-3">
                        <div>
                            <h3 className="text-xl">Lựa chọn thêm cho các workshop bạn muốn đặt:</h3>
                            <div>
                                <div>
                                    {data.channels.map((channel, index) => (
                                        <div key={index}>
                                            {channel.rooms.map((room, index) => (
                                                <div key={index}>
                                                    {room.sessions.map((session) => (
                                                        <OptionWorkshop
                                                            key={session.id}
                                                            checked={checkWorkshop.includes(session.id)}
                                                            onChange={() =>
                                                                changeCheckWorkshop(session.id, session.cost)
                                                            }
                                                            id={session.id}
                                                            name={session.title}
                                                        />
                                                    ))}
                                                </div>
                                            ))}
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                        <div className="flex flex-col items-end">
                            <div className="w-1/3 text-lg">
                                <div className="flex justify-between">
                                    <span>Vé sự kiện:</span>
                                    <span>{bill.ticketPrice} -</span>
                                </div>
                                <div className="flex justify-between">
                                    <span>workshop bổ sung:</span>
                                    <span>{bill.workshop} -</span>
                                </div>
                                <div className="flex justify-between font-medium border-t-2 border-black border-solid">
                                    <span>Tổng:</span>
                                    <span>{bill.ticketPrice + bill.workshop} -</span>
                                </div>
                                <div className="flex justify-end">
                                    <button
                                        onClick={handleBuy}
                                        className={`text-white rounded-md py-1 px-6 mt-8 ${
                                            checkTicket !== 0 ? 'bg-sky-500' : 'bg-sky-500/20 pointer-events-none'
                                        }`}
                                    >
                                        Mua
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default RegisterEvent;
