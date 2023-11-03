import { useId } from 'react';

const OptionWorkshop = ({ id, name, checked, onChange = () => {} }) => {
    const idCheckBox = useId();
    return (
        <div className="flex items-center mt-4">
            <input checked={checked} onChange={onChange} id={idCheckBox} type="checkbox" className="mt-[3px]" />
            <label className="pl-1 text-lg cursor-pointer" htmlFor={idCheckBox}>
                {name}
            </label>
        </div>
    );
};

export default OptionWorkshop;
