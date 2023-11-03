import { Link } from 'react-router-dom';
const Event = () => {
    return (
        <div className="max-w-default mx-auto">
            <header className="border-b border-gray-500 border-solid">
                <div className="flex items-center justify-between p-4">
                    <h1 className="text-3xl font-semibold">React conf 2019</h1>
                    <Link
                        to="/register-event/react-conf-2019"
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
                            <th className="w-1/12"></th>
                            <th className="font-normal text-lg py-2 pl-2">09:00</th>
                            <th className="font-normal text-lg py-2 pl-2">11:00</th>
                            <th className="font-normal text-lg py-2 pl-2">13:00</th>
                            <th className="font-normal text-lg py-2 pl-2">15:00</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr className="border-y border-slate-400 border-solid">
                            <td>asda adfad adfasdf asdfasfa sfasfasf adsfasf asdfasf</td>
                            <td className="border-x border-slate-400 border-solid">asda adfad adfasdf</td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-black border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-black border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                        </tr>
                        <tr className="border-y border-slate-400 border-solid">
                            <td>asda adfad adfasdf asdfasfa sfasfasf adsfasf asdfasf</td>
                            <td className="border-x border-slate-400 border-solid">asda adfad adfasdf</td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-black border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-black border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                        </tr>
                        <tr className="border-y border-slate-400 border-solid">
                            <td>asda adfad adfasdf asdfasfa sfasfasf adsfasf asdfasf</td>
                            <td className="border-x border-slate-400 border-solid">asda adfad adfasdf</td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-black border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                            <td className="px-2 py-4">
                                <div className="p-2 border-[3px] border-black border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                                <div className="p-2 border-[3px] border-green-600 border-solid inline-block mr-4 mb-2">
                                    This is meet
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default Event;
