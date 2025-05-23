import serial
import oracledb
from datetime import datetime
import logging
from serial.serialutil import SerialException  # ✅ explicitly import SerialException

# Initialize logging
logging.basicConfig(level=logging.INFO, format="%(asctime)s - %(levelname)s - %(message)s")

# Oracle client library path
oracledb.init_oracle_client(lib_dir=r"C:\oracle\instantclient_19_11")

# Arduino Serial Port Settings
SERIAL_PORT = 'COM3'
BAUD_RATE = 9600

# Oracle DB Connection
DB_USER = "freshblink-db"
DB_PASS = "Tester1!"
DB_CONN = "127.0.0.1/XE"


def get_serial_uid():
    try:
        with serial.Serial(SERIAL_PORT, BAUD_RATE, timeout=10) as arduino:
            logging.info("Waiting for RFID UID scan...")
            while True:
                line = arduino.readline().decode('utf-8').strip()
                if line.startswith("RFID Tag UID:"):
                    uid = line.replace("RFID Tag UID:", "").strip()
                    return uid
    except SerialException as e:
        logging.error(f"Error reading serial port: {e}")
        return None


def check_uid_exists(cursor, uid):
    cursor.execute("SELECT COUNT(*) FROM PRODUCT WHERE PRODUCT_DETAILS LIKE :1", (f"%{uid}%",))
    result = cursor.fetchone()
    return result[0] > 0


def insert_product(cursor, uid):
    print("\nEnter product details:")
    
    product_type = input("Product Type (e.g., Bakery, Butcher, etc.): ")
    product_name = input("Product Name: ")

    try:
        product_price = float(input("Price: "))
    except ValueError:
        logging.warning("Invalid price. Must be a number.")
        return

    product_details = input("Product Details: ")

    try:
        stock = int(input("Stock Quantity: "))
    except ValueError:
        logging.warning("Invalid stock quantity. Must be an integer.")
        return

    product_image = input("Product Image path (e.g., images/bakery_01.png): ")
    shop_id = input("Shop ID: ")
    
    try:
        product_verification = int(input("Product Verification (0 or 1): ") or 0)
    except ValueError:
        logging.warning("Invalid verification input. Defaulting to 0.")
        product_verification = 0

    product_details_with_uid = f"{product_details} (RFID: {uid})"

    sql = """
        INSERT INTO Product (
            Product_Id, Product_Type, Product_Name, Product_Price,
            Product_Details, Stock, Product_Image, Shop_Id, Product_Verification
        ) VALUES (
            Product_Id_seq.NEXTVAL, :product_type, :product_name, :product_price,
            :product_details, :stock, :product_image, :shop_id, :product_verification
        )
    """
    
    cursor.execute(sql, {
        'product_type': product_type,
        'product_name': product_name,
        'product_price': product_price,
        'product_details': product_details_with_uid,
        'stock': stock,
        'product_image': product_image,
        'shop_id': shop_id,
        'product_verification': product_verification
    })


def main():
    try:
        with oracledb.connect(user=DB_USER, password=DB_PASS, dsn=DB_CONN) as conn:
            with conn.cursor() as cursor:
                logging.info("Connected to Oracle DB successfully.")

                while True:
                    uid = get_serial_uid()
                    if not uid:
                        logging.warning("No UID read. Try again.")
                        continue

                    logging.info(f"Scanned UID: {uid}")

                    if check_uid_exists(cursor, uid):
                        logging.info("Item already in the database. Please scan a unique item.")
                    else:
                        logging.info("UID is new. Let's add the product.")
                        insert_product(cursor, uid)
                        conn.commit()
                        logging.info("🎉 Product inserted successfully.")

                    cont = input("Scan another? (y/n): ")
                    if cont.lower() != 'y':
                        break

    except oracledb.DatabaseError as e:
        logging.error(f"Database connection error: {e}")
    except KeyboardInterrupt:
        logging.info("Process interrupted by user.")
    finally:
        logging.info("Application terminated.")


if __name__ == "__main__":
    main()
