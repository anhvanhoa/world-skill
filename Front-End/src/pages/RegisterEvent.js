import TypeTicket from '../components/TypeTicket';
import OptionWorkshop from '../components/OptionWorkshop';
import { useState } from 'react';

const dataTypeTicket = [
    {
        id: 1,
        name: 'Vé thường',
        const: 210,
        amount: 10,
    },
    {
        id: 2,
        name: 'Đặt sớm không có sẵn',
        const: 110,
        amount: 0,
    },
    {
        id: 3,
        name: 'VIP 50 vé có sẵn',
        const: 300,
        amount: 50,
    },
];
const dataWorkshop = [
    {
        id: 1,
        name: 'Designing skill path',
        const: 30,
    },
    {
        id: 2,
        name: 'Education ecosyste',
        const: 30,
    },
    {
        id: 3,
        name: 'Training innovat',
        const: 30,
    },
];
const RegisterEvent = () => {
    const [checkTicket, setCheckTicket] = useState([]);
    const [checkWorkshop, setCheckWorkshop] = useState([]);
    const [bill, setBill] = useState({
        ticketPrice: 0,
        workshop: 0,
    });
    const changeCheckTicket = (id, price) => {
        if (checkTicket.includes(id)) {
            setCheckTicket(checkTicket.filter((elem) => elem !== id));
            setBill((prev) => ({ ...prev, ticketPrice: prev.ticketPrice + price }));
        } else {
            setCheckTicket((prev) => [...prev, id]);
            setBill((prev) => ({ ...prev, ticketPrice: prev.ticketPrice - price }));
        }
    };
    const changeCheckWorkshop = (id, price) => {
        if (checkWorkshop.includes(id)) {
            setCheckWorkshop(checkWorkshop.filter((elem) => elem !== id));
            setBill((prev) => ({ ...prev, workshop: prev.workshop + price }));
        } else {
            setCheckWorkshop((prev) => [...prev, id]);
            setBill((prev) => ({ ...prev, workshop: prev.workshop - price }));
        }
    };
    return (
        <div>
            <div className="max-w-5xl mx-auto">
                <header>
                    <div className="flex items-center justify-between p-4">
                        <h1 className="text-3xl font-semibold">React conf 2019</h1>
                    </div>
                </header>
                <div className="p-4">
                    <div className="grid grid-cols-3">
                        {dataTypeTicket.map((item) => (
                            <TypeTicket
                                key={item.id}
                                amount={item.amount}
                                price={item.const}
                                name={item.name}
                                checked={checkTicket.includes(item.id)}
                                onChange={() => changeCheckTicket(item.id, item.const)}
                            />
                        ))}
                    </div>
                    <div className="mt-3">
                        <div>
                            <h3 className="text-xl">Lựa chọn thêm cho các workshop bạn muốn đặt:</h3>
                            <div>
                                {dataWorkshop.map((element) => (
                                    <OptionWorkshop
                                        key={element.id}
                                        checked={checkWorkshop.includes(element.id)}
                                        onChange={() => changeCheckWorkshop(element.id, element.const)}
                                        id={element.id}
                                        name={element.name}
                                    />
                                ))}
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
                                        className={`text-white rounded-md py-1 px-6 mt-8 ${
                                            checkTicket.length > 0 ? 'bg-sky-500' : 'bg-sky-500/20 pointer-events-none'
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
