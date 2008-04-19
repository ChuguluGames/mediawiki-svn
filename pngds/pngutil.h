#ifndef	_PNGUTIL_H
#define _PNGUTIL_H	1

void png_die(char *msg, void *data);
void png_read_int(u_int32_t *ptr, FILE *stream, u_int32_t *crc);
unsigned int png_fread(void *ptr, unsigned int size, FILE *stream, u_int32_t *crc);
void png_open_streams(void **options, FILE **in, FILE **out);
void png_write_int(u_int32_t value, FILE *stream, u_int32_t *crc);
unsigned int png_fwrite(void *ptr, unsigned int size, FILE *stream, u_int32_t *crc);

#endif
