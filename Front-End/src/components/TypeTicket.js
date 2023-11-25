import { useId } from 'react';
const TypeTicket = ({ available, price, name, checked, onChange = () => {} }) => {
    const idCheckBox = useId();
    return (
        <div>
            <label
                htmlFor={idCheckBox}
                className={`flex justify-between items-center p-4 border border-solid cursor-pointer ${
                    !available ? 'text-[#a4a4a4] pointer-events-none' : 'border-black'
                }`}
            >
                <input onChange={onChange} checked={checked} id={idCheckBox} type="checkbox" />
                <p className="text-xl font-medium">{name}</p>
                <p className="font-medium">{price} -</p>
            </label>
        </div>
    );
};

export default TypeTicket;
