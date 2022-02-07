import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:photo_view/photo_view.dart';

class CustomImage extends StatelessWidget {
  final String imageUrl;
  final bool isNetwork;
  CustomImage(this.imageUrl, this.isNetwork);

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => PhotoViewRouteWrapper(
              
              imageProvider: isNetwork
                  ? NetworkImage(
                      this.imageUrl,
                    )
                  : FileImage(File(this.imageUrl)) as ImageProvider,
            ),
          ),
        );
      },
      child: PhotoView(
        imageProvider: isNetwork
            ? NetworkImage(this.imageUrl) as ImageProvider
            : FileImage(File(this.imageUrl)),
        // imageProvider: FileImage(File(this.imageUrl)),
        // imageProvider: kIsWeb
        //                   ? NetworkImage(this.imageUrl) as ImageProvider
        //                   : FileImage(File(this.imageUrl)) as ImageProvider,
        minScale: PhotoViewComputedScale.contained * 0.8,
        maxScale: PhotoViewComputedScale.covered * 2,
      ),
    );
  }
}

class PhotoViewRouteWrapper extends StatelessWidget {
  final ImageProvider imageProvider;
  final BoxDecoration? backgroundDecoration;
  final dynamic minScale;
  final dynamic maxScale;

  const PhotoViewRouteWrapper({
    required this.imageProvider,
    this.backgroundDecoration,
    this.minScale,
    this.maxScale,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      constraints: BoxConstraints.expand(
        height: MediaQuery.of(context).size.height,
      ),
      child: PhotoView(
        imageProvider: imageProvider,
        backgroundDecoration: backgroundDecoration,
        minScale: minScale,
        maxScale: maxScale,
      ),
    );
  }
}
