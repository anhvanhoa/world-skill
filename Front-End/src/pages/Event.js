import { Link, useParams } from 'react-router-dom';
import { useState, useEffect } from 'react';
const Event = () => {
    const params = useParams();
    const [data, setData] = useState({ channels: [{ rooms: [{ sessions: [] }] }] });
    const url = process.env.REACT_APP_REQUESTS;
    useEffect(() => {
        const events = fetch(`${url}/organizers/${params.slugOrganizer}/events/${params.slugEvent}`);
        events.then((res) => res.json()).then((data) => setData(data));
    }, [params.slugEvent, params.slugOrganizer, url]);
    return (
        <div className="max-w-default mx-auto">
            <header className="border-b border-gray-500 border-solid">
                <div className="flex items-center justify-between p-4">
                    <h1 className="text-3xl font-semibold">React conf 2019</h1>
                    <Link
                        to={`/register-event/${params.slugOrganizer}/${params.slugEvent}`}
                        className="bg-green-600 px-4 py-1 rounded-md text-white text-lg"
                    >
                        Đăng ký sự kiện này
                    </Link>
                </div>
            </header>
            <div>
                <table className="table-auto border-collapse w-full mt-10 text-left">
                    <thead>
                        <tr>
                            <th className="w-1/5"></th>
                            <th className="w-full flex">
                                <p className="w-1/6 pr-2"></p>
                                <div className="flex flex-1 justify-between">
                                    <p className="font-normal text-lg py-2 pl-2">09:00</p>
                                    <p className="font-normal text-lg py-2 pl-2">11:00</p>
                                    <p className="font-normal text-lg py-2 pl-2">13:00</p>
                                    <p className="font-normal text-lg py-2 pl-2">15:00</p>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.channels.map((channel, i) => (
                            <tr key={i} className="border-y border-slate-400 border-solid">
                                <td>{channel.name}</td>
                                <td className="border-l border-slate-400 border-solid">
                                    {channel.rooms.map((room, i) => (
                                        <div key={i} className="flex items-center">
                                            <p className="w-1/6 px-2">{room.name}</p>
                                            <div className="border-l border-slate-400 border-solid pl-6 w-full py-3">
                                                {room.sessions.map((session, i) => (
                                                    <div
                                                        key={i}
                                                        className={`${
                                                            session.type === 'talk'
                                                                ? 'border-green-600'
                                                                : 'border-black'
                                                        } p-2 border-[3px] border-solid inline-block mr-4 mb-2 flex-shrink-0`}
                                                    >
                                                        {session.title}
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                    ))}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default Event;
