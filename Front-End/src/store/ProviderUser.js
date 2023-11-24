import { createContext, useState } from 'react';
const contextUser = createContext();
const ProviderUser = ({ children }) => {
    const [user, setUser] = useState(null);
    return (
        <div>
            <contextUser.Provider value={{ user, setUser }}>{children}</contextUser.Provider>
        </div>
    );
};
export { contextUser };
export default ProviderUser;
